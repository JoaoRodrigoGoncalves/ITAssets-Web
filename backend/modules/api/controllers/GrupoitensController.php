<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
        unset($actions['delete'], $actions['index'],$actions['create']);
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

    public function actionCreate()
    {
        $this->checkAccess('create');

        $model = new Grupoitens();
        $data = Yii::$app->getRequest()->getBodyParams();

        if (isset($data['nome'])) {
            if (isset($data['itens'])) {

                //carregar os dados para o model
                $model->nome = $data['nome'];
                $model->notas = $data['notas'];
                $model->save();
                $itens = $data['itens'];

                for ($i = 0; $i < count($itens); $i++) {

                    $item = Item::findOne(['id' => $itens[$i]]);

                    //ve se o item existe na bd
                    if ($item != null)
                    {
                        //validação se o item esta associado algo
                        if (!$item->isInActivePedidoAlocacao() || !$item->isInActiveItemsGroup())
                        {
                            $grupoitensItem = new GruposItens_Item();
                            $grupoitensItem->grupoItens_id= $model->id;
                            $grupoitensItem->item_id = $itens[$i];
                            $grupoitensItem->save();
                        }
                        else
                        {
                            $model->delete(); //elimina o grupo item que foi criado caso aconteça isto
                            throw new BadRequestHttpException("O Item " . $item->nome . " já se encontra em utilização.");
                        }
                    }
                    else
                    {
                        $model->delete();
                        throw new BadRequestHttpException("O Item não existe.");
                    }
                }

                return $model; // Criado com sucesso

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

    public function actionDelete($id)
    {
        $this->checkAccess('create');

        $model = Grupoitens::findOne(['id' => $id]);
        if($model != null)
        {
            $model->status = Grupoitens::STATUS_DELETED;
            $model->save();
            Yii::$app->getResponse()->setStatusCode(204);
        }
        else
        {
            throw new NotFoundHttpException("Grupo não encontrado.");
        }
    }
}