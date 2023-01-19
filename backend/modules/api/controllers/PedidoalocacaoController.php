<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\Item;
use common\models\PedidoAlocacao;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

use yii\web\ConflictHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class PedidoalocacaoController extends ActiveController
{
    public $modelClass = 'common\models\PedidoAlocacao';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['formats'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['delete'], $actions['update'], $actions['create']);
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
                if(!Yii::$app->user->can('readOthersPedidoAlocacao'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            case "pedidoalocacaouser":
            case "create":
                if(!Yii::$app->user->can('createPedidoAlocacao'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "view":
                if(Yii::$app->user->can('createPedidoAlocacao'))
                {
                    // Apenas o proprio requerente e utilizadores com permissão para ver os pedidos de outros é que podem
                    // ver o pedido de alocação. Sendo assim, verificamos se o pedido de alocação indicado foi realizado
                    // pelo utilizador que fez o pedido à API. Se não foi, verificamos se o utilizador que fez o pedido à
                    // API tem permissão para ver os pedidos de outros utilizadores.

                    // Assumimos que o item existe porque esta parte só é executada depois da validação na ação
                    if(PedidoAlocacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null && !Yii::$app->user->can('readOthersPedidoAlocacao'))
                    {
                        throw new ForbiddenHttpException();
                    }
                }
                break;

            case "update":
                // Não existe edição dos dados de um pedido. Este método é usado para aprovar/negar/devolver um pedido
                if(!Yii::$app->user->can('changeStatusPedidoAlocacao'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "delete":
                if(Yii::$app->user->can('cancelPedidoAlocacao'))
                {
                    if(PedidoAlocacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null)
                    {
                        throw new ForbiddenHttpException("Apenas o requerente pode cancelar o pedido");
                    }
                }
                else
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

    public function actionPedidoalocacaouser($user_id){
        $this->checkAccess('pedidoalocacaouser');
        return PedidoAlocacao::findAll(['requerente_id' => $user_id]);
    }

    public function actionView($id)
    {
        $this->checkAccess('view', null, ['id' => $id]);

        $pedido =  PedidoAlocacao::findOne($id);

        if($pedido != null)
        {
            return $pedido;
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado");
        }
    }

    public function actionCreate(){
        $this->checkAccess("create");

        //Cria um Novo Pedido de Alocação
        $model = new PedidoAlocacao();
        $data = Yii::$app->getRequest()->getBodyParams();

        if(!isset($data['requerente_id']))
        {
            throw new UnprocessableEntityHttpException("Campo \"requerente_id\" é obrigatório");
        }

        $model->requerente_id = $data['requerente_id'];

        if(isset($data['obs']))
        {
            $model->obs = $data['obs'];
        }

        $authmgr = Yii::$app->authManager;

        if(in_array(array_keys($authmgr->getRolesByUser(Yii::$app->user->id))[0], [$authmgr->getRole('administrador')->name, $authmgr->getRole('operadorlogistica')->name]))
        {
            // Se for administrador ou operador logistico, o pedido é imediatamente aceite
            $model->aprovador_id = Yii::$app->user->id;
            $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");
            $model->status = PedidoAlocacao::STATUS_APROVADO;
        }

        if(!isset($data['item_id']) && !isset($data['grupoItem_id']))
        {
            throw new UnprocessableEntityHttpException("É necessário indicar um item ou um grupo de itens");
        }

        //Valida se foi colocado um item e um grupo no mesmo pedido: caso aconteça tem de dar erro
        if(isset($data['item_id']) && isset($data['grupoItem_id']))
        {
            throw new BadRequestHttpException("Não é possível selecionar um item e um grupo de itens.");
        }

        //Valida se o item exite na base de dados
        //Valida se o item não está associado num grupo de itens nem alocado
        if(isset($data['item_id']))
        {
            $item = Item::findOne($data['item_id']);

            //ve se o item existe na bd
            if ($item != null)
            {
                //O Item não pode estar num grupo de itens nem alocado
                if (!$item->isInActiveItemsGroup() && !$item->isInActivePedidoAlocacao())
                {
                    $model->item_id = $data['item_id'];
                    $model->grupoItem_id = null;
                    if($model->save())
                    {
                        return PedidoAlocacao::findOne($model->id);
                    }
                    else
                    {
                        throw new ServerErrorHttpException("Erro ao guardar alterações");
                    }
                }
                else
                {
                    throw new BadRequestHttpException("O Item não pode estar associado a um Grupo de itens e nem Alocado");
                }
            }
            else
            {
                throw new BadRequestHttpException("O Item não existe");
            }
        }

        //Valida se o grupo de itens exite na base de dados
        //Valida se o grupo de itens não está alocado
        if(isset($data['grupoItem_id']))
        {
            $grupoItens = Grupoitens::findOne($data['grupoItem_id']);

            //ve se o grupo de itens existe na bd
            if ($grupoItens != null)
            {
                //O Grupo de Itens não pode estar alocado
                if (!$grupoItens->isinActivePedidoAlocacao())
                {
                    $model->item_id = null;
                    $model->grupoItem_id = $data['grupoItem_id'];

                    if($model->save())
                    {
                        return PedidoAlocacao::findOne($model->id);
                    }
                    else
                    {
                        throw new ServerErrorHttpException("Erro ao guardar alterações");
                    }
                }
                else
                {
                    throw new BadRequestHttpException("O Grupo de Item não pode estar Alocado");
                }
            }
            else
            {
                throw new BadRequestHttpException("O Grupo de Itens não existe");
            }
        }
        throw new ServerErrorHttpException();
    }

    public function actionUpdate($id){
        $this->checkAccess("update");
        $model = PedidoAlocacao::findOne(['id' => $id]);

        if($model != null)
        {
            $data = Yii::$app->getRequest()->getBodyParams();

            switch ($data['status'])
            {
                /** Caso o status seja igual a 9, ou seja, APROVADO **/
                case PedidoAlocacao::STATUS_APROVADO:
                    if($model->status == PedidoAlocacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoAlocacao::STATUS_APROVADO;
                        $model->aprovador_id = Yii::$app->user->id;
                        $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");

                        if(isset($data['obsResposta']))
                        {
                            $model->obsResposta = $data['obsResposta'];
                        }

                        if(!$model->save())
                        {
                            throw new ServerErrorHttpException("Erro ao guardar alterações");
                        }
                    }
                    else
                    {
                        throw new ConflictHttpException("Não é possível aprovar um pedido depois de processado.");
                    }
                    break;

                /** Caso o status seja igual a 7, ou seja, DEVOLVIDO **/
                case PedidoAlocacao::STATUS_DEVOLVIDO:
                    if($model->status == PedidoAlocacao::STATUS_APROVADO)
                    {
                        $authmgr = Yii::$app->authManager;
                        $allowedRoles = [$authmgr->getRole('administrador')->name, $authmgr->getRole('operadorlogistica')->name];

                        if(in_array(array_keys($authmgr->getRolesByUser(Yii::$app->user->id))[0], $allowedRoles))
                        {
                            $model->status = PedidoAlocacao::STATUS_DEVOLVIDO;
                            $model->dataFim = date_format(date_create(), "Y-m-d H:i:s");
                            if(!$model->save())
                            {
                                throw new ServerErrorHttpException("Erro ao guardar alterações");
                            }
                        }
                        else
                        {
                            throw new ForbiddenHttpException("Apenas um utilizador administrativo pode marcar objetos como devolvidos");
                        }
                    }
                    else
                    {
                        throw new ConflictHttpException("Não é possível devolver um pedido depois de processado.");
                    }
                    break;

                /** Caso o status seja igual a 8, ou seja, NEGADO **/
                case PedidoAlocacao::STATUS_NEGADO:
                    if($model->status == PedidoAlocacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoAlocacao::STATUS_NEGADO;
                        $model->aprovador_id = Yii::$app->user->id;
                        $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");

                        if(isset($data['obsResposta']))
                        {
                            $model->obsResposta = $data['obsResposta'];
                        }

                        if(!$model->save())
                        {
                            throw new ServerErrorHttpException("Erro ao guardar alterações");
                        }
                    }
                    else
                    {
                        throw new ConflictHttpException("Não é possível negar um pedido depois de processado");
                    }
                    break;

                default:
                    throw new UnprocessableEntityHttpException("Estado indicado inválido");
            }
            return $model;
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado");
        }
    }

    public function actionDelete($id)
    {
        $model = PedidoAlocacao::findOne(['id' => $id]);

        if($model != null)
        {
            $this->checkAccess("delete", null, ['id' => $id]); // Deixar aqui mesmo porque o checkAccess requer que o pedido exista

            if($model->status == PedidoAlocacao::STATUS_ABERTO)
            {
                $model->status = PedidoAlocacao::STATUS_CANCELADO;
                $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");
                if($model->save())
                {
                    Yii::$app->getResponse()->setStatusCode(204);
                }
                else
                {
                    throw new ServerErrorHttpException("Erro ao guardar alterações");
                }
            }
            else
            {
                throw new ConflictHttpException("Não é possível cancelar um pedido depois de processado.");
            }
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado.");
        }
    }
}
