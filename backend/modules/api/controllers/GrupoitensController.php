<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use common\models\PedidoAlocacao;
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


class GrupoitensController  extends ActiveController
{
    public $modelClass = 'common\models\Grupoitens';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        //para indicar que a resposta vem em json
        $behaviors['formats'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        //Token do user para confirmar a autenticação
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        switch ($action)
        {
            case "index":
            case "view":
                if(!Yii::$app->user->can('readGrupoItens'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "create":
            case "update":
            case "delete":
                if(!Yii::$app->user->can('writeGrupoItens'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

    public function actionIndex()
    {
        $this->checkAccess('index');
        return Grupoitens::findAll(['status' => Grupoitens::STATUS_ACTIVE]);
    }

    public function actionGrupositensuser($user_id)
    {
        $this->checkAccess('index'); // Porque é baseado em index

        $authmgr = Yii::$app->authManager;
        $allowedRoles = [$authmgr->getRole('administrador')->name, $authmgr->getRole('operadorlogistica')->name];

        if(!(Yii::$app->user->id == $user_id || in_array(array_keys($authmgr->getRolesByUser(Yii::$app->user->id))[0], $allowedRoles)))
        {
            throw new ForbiddenHttpException();
        }


        $grupo_arr = [];
        foreach (User::findOne($user_id)->pedidosAlocacaoAsRequester as $pedido)
        {
            if($pedido->status == PedidoAlocacao::STATUS_APROVADO)
            {
                if ($pedido->grupoItem != null)
                {
                    $grupo_arr[] = $pedido->grupoItem;
                }

            }
        }
        return $grupo_arr;
    }

    public function actionCreate()
    {
        $this->checkAccess('create');

        $model = new Grupoitens();
        $data = Yii::$app->getRequest()->getBodyParams();

        if (isset($data['nome'])) {
            if (isset($data['itens'])) {

                //carregar os dados para o model
                $model->nome = $data['nome'];

                if(isset($data['notas']))
                {
                    $model->notas = $data['notas'];
                }

                if(!$model->save())
                {
                    throw new ServerErrorHttpException("Erro ao guardar alterações");
                }

                $itens = $data['itens'];

                if(count($itens) > 0)
                {
                    for ($i = 0; $i < count($itens); $i++) {
                        $item = Item::findOne(['id' => $itens[$i]]);

                        //ve se o item existe na bd
                        if ($item != null)
                        {
                            //validação se o item esta associado algo
                            if (!$item->isInActiveItemsGroup() && !$item->isInActivePedidoAlocacao())
                            {
                                $grupoitensItem = new GruposItens_Item();
                                $grupoitensItem->grupoItens_id= $model->id;
                                $grupoitensItem->item_id = $itens[$i];
                                if(!$grupoitensItem->save())
                                {
                                    GruposItens_Item::deleteAll(['grupoItens_id' => $model->id]);
                                    $model->delete(); //elimina o grupo item que foi criado caso aconteça isto
                                    throw new ServerErrorHttpException("Erro ao guardar alterações");
                                }
                            }
                            else
                            {
                                GruposItens_Item::deleteAll(['grupoItens_id' => $model->id]);
                                $model->delete(); //elimina o grupo item que foi criado caso aconteça isto
                                throw new BadRequestHttpException("O Item " . $item->nome . " já se encontra em utilização.");
                            }
                        }
                        else
                        {
                            GruposItens_Item::deleteAll(['grupoItens_id' => $model->id]);
                            $model->delete();
                            throw new BadRequestHttpException("O Item não existe.");
                        }
                    }

                    return $model; // Criado com sucesso
                }
                else
                {
                    throw new UnprocessableEntityHttpException("É obrigatório indicar pelo menos um item.");
                }
            }
            else
            {
                throw new UnprocessableEntityHttpException("É obrigatório indicar itens.");
            }
        }
        else
        {
            throw new UnprocessableEntityHttpException("O Campo \"nome\" é obrigatório.");
        }
    }

    public function actionUpdate($id)
    {
        $this->checkAccess('update');

        $grupo = Grupoitens::findOne($id);
        if($grupo != null)
        {
            $data = Yii::$app->getRequest()->getBodyParams();

            if(isset($data['nome']))
            {
                $grupo->nome = $data['nome'];
            }

            if(isset($data['notas']))
            {
                $grupo->notas = $data['notas'];
            }

            if($grupo->save())
            {
                return $grupo;
            }
            else
            {
                throw new ServerErrorHttpException("Erro ao guardar alterações");
            }
        }
        else
        {
            throw new NotFoundHttpException("Grupo não encontrado");
        }
    }

    public function actionDelete($id)
    {
        $this->checkAccess('create');

        $model = Grupoitens::findOne(['id' => $id]);
        if($model != null)
        {
            if(!$model->isinActivePedidoAlocacao())
            {
                $model->status = Grupoitens::STATUS_DELETED;
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
                throw new ConflictHttpException("O Grupo está alocado e por isso não pode ser removido.");
            }
        }
        else
        {
            throw new NotFoundHttpException("Grupo não encontrado.");
        }
    }
}