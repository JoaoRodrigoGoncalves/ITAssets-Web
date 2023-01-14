<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use common\models\LinhaPedidoReparacao;
use common\models\PedidoReparacao;
use common\models\User;
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

class PedidoreparacaoController extends ActiveController
{
    public $modelClass = 'common\models\PedidoReparacao';

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
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
                if(!Yii::$app->user->can('readOthersPedidoReparacao'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            case "pedidosreparacaouser":
            case "create":
                if(!Yii::$app->user->can('createPedidoReparacao'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            case "view":
                if(Yii::$app->user->can('createPedidoReparacao'))
                {
                    // Apenas o proprio requerente e utilizadores com permissão para ver os pedidos de outros é que podem
                    // ver o pedido de alocação. Sendo assim, verificamos se o pedido de alocação indicado foi realizado
                    // pelo utilizador que fez o pedido à API. Se não foi, verificamos se o utilizador que fez o pedido à
                    // API tem permissão para ver os pedidos de outros utilizadores.

                    // Assumimos que o item existe porque esta parte só é executada depois da validação na ação
                    if(PedidoReparacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null && !Yii::$app->user->can('readOthersPedidoAlocacao'))
                    {
                        throw new ForbiddenHttpException();
                    }
                }
            break;

            case "update":
                // Não existe edição dos dados de um pedido. Este método é usado para aprovar/negar/devolver um pedido
                if(!Yii::$app->user->can('changeStatusPedidoReparacao'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            case "delete":
                if(Yii::$app->user->can('cancelPedidoReparacao'))
                {
                    if(PedidoReparacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null)
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

    public function actionPedidosreparacaouser($user_id)
    {
        $this->checkAccess('pedidosreparacaouser');
        return PedidoReparacao::findAll(['requerente_id' => $user_id]);
    }

    public function actionCreate()
    {
        $this->checkAccess("create");

        $data = Yii::$app->getRequest()->getBodyParams();

        if(!isset($data['requerente_id'], $data['descricaoProblema']))
        {
            throw new UnprocessableEntityHttpException("Campo(s) em falta");
        }

        $items_list = [];
        //Valida se o item exite na base de dados
        //Valida se o item não está associado num grupo de itens nem alocado
        if(isset($data['items']))
        {
            foreach ((array)$data['items'] as $item_id)
            {
                $item = Item::findOne($item_id);

                if($item != null)
                {
                    //O Item não pode estar num grupo de itens nem alocado
                    if (!$item->isInActiveItemsGroup() && $item->isInActivePedidoAlocacao() && !$item->isInActivePedidoReparacao())
                    {
                        if($item->isAlocatedToUser($data['requerente_id']))
                        {
                            $items_list[] = $item->id;
                        }
                        else
                        {
                            throw new ForbiddenHttpException("O Item " . $item->nome . " está associado a outro utilizador.");
                        }
                    }
                    else
                    {
                        throw new BadRequestHttpException("O Item não pode estar associado a um Grupo de itens ou já associado a um pedido de reparação");
                    }
                }
                else
                {
                    throw new BadRequestHttpException("O Item " . $item_id . " é inválido");
                }
            }
        }

        $grupos_list = [];
        //Valida se o grupo de itens exite na base de dados
        //Valida se o grupo de itens não está alocado
        if(isset($data['grupoItem_id']))
        {
            foreach ((array)$data['grupoItens'] as $grupoItem)
            {
                $grupo = Grupoitens::findOne($grupoItem);

                if($grupo != null)
                {
                    if($grupo->isinActivePedidoAlocacao() && !$grupo->isInActivePedidoReparacao())
                    {
                        if($grupo->isAlocatedToUser($data['requerente_id']))
                        {
                            $grupos_list[] = $grupo->id;
                        }
                        else
                        {
                            throw new ForbiddenHttpException("O Grupo " . $grupo->nome . " está alocado a outro utilizador");
                        }
                    }
                    else
                    {
                        throw new BadRequestHttpException("O Grupo de Item não pode estar Alocado nem noutro Pedido de Reparação ativo");
                    }
                }
                else
                {
                    throw new BadRequestHttpException("O Grupo de Itens não existe");
                }
            }
        }

        $model = new PedidoReparacao();

        if($data['requerente_id'] != Yii::$app->user->id)
        {
            if(!Yii::$app->user->can('seeOthersPedidoReparacao'))
            {
                throw new ForbiddenHttpException("Não tem permissão para criar um pedido de reparação em nome de outro utilizador");
            }
        }

        $model->requerente_id = $data['requerente_id'];
        $model->descricaoProblema = $data['descricaoProblema'];
        $model->status = PedidoReparacao::STATUS_EM_PREPARACAO;
        $model->save();

        if(count($items_list) > 0)
        {
            foreach ($items_list as $item) {
                $associacao = new LinhaPedidoReparacao();
                $associacao->item_id = $item;
                $associacao->grupo_id = null;
                $associacao->pedido_id = $model->id;
                $associacao->save();
            }
        }

        if(count($grupos_list) > 0)
        {
            foreach ($grupos_list as $grupo)
            {
                $associacao = new LinhaPedidoReparacao();
                $associacao->item_id = null;
                $associacao->grupo_id = $grupo;
                $associacao->pedido_id = $model->id;
                $associacao->save();
            }
        }

        $model->status = PedidoReparacao::STATUS_ABERTO;
        $model->save();

        return PedidoReparacao::findOne($model->id); // Para ter a certeza que traz tudo
    }

    public function actionUpdate($id){
        $this->checkAccess("update");
        $model = PedidoReparacao::findOne(['id' => $id]);

        if($model != null)
        {
            $data = Yii::$app->getRequest()->getBodyParams();

            switch ($data['status'])
            {
                /** Caso o status seja igual a 6, ou seja, EM_REVISAO **/
                case PedidoReparacao::STATUS_EM_REVISAO:
                    if($model->status == PedidoReparacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoReparacao::STATUS_EM_REVISAO;
                        $model->responsavel_id = Yii::$app->user->id;
                        $model->save();

                        return $model;
                    }
                    else
                    {
                        throw new ConflictHttpException("Não é possível iniciar revisão de um pedido depois de processado.");
                    }
                break;

                /** Caso o status seja igual a 4, ou seja, CONCLUIDO **/
                case PedidoReparacao::STATUS_CONCLUIDO:
                    if($model->status == PedidoReparacao::STATUS_EM_REVISAO)
                    {
                        $model->status = PedidoReparacao::STATUS_CONCLUIDO;
                        $model->respostaObs = $data['respostaObs'];
                        $model->save();

                        return $model;
                    }
                    else
                    {
                        throw new ConflictHttpException("Não é possível concluir um pedido antes de iniciar a revisão.");
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
        $model = PedidoReparacao::findOne(['id' => $id]);

        if($model != null)
        {
            $this->checkAccess("delete", null, ['id' => $id]); // Deixar aqui mesmo porque o checkAccess requer que o pedido exista

            if($model->status == PedidoReparacao::STATUS_ABERTO)
            {
                $model->status = PedidoReparacao::STATUS_CANCELADO;
                $model->save();
                Yii::$app->getResponse()->setStatusCode(204);
            }
            else
            {
                throw new BadRequestHttpException("Não é possível cancelar um pedido depois de processado.");
            }
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado.");
        }
    }
}
