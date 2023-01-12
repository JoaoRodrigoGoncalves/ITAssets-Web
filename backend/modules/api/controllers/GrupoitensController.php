<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\GruposItens_Item;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


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
                if(!Yii::$app->user->can('readItem'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "create":
            case "update":
            case "delete":
                if(!Yii::$app->user->can('writeItem'))
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
        $model = new Grupoitens();
        $data= Yii::$app->getRequest()->getBodyParams();

        if (isset($data['nome']))
        {
            if (isset($data['itens']))
            {

                //carregar os dados para o model
                $model->nome=$data['nome'];
                $model->notas=$data['notas'];
                $model->save();

                $itens = $data['itens'];
                for ($i = 0; $i < count($itens); $i++)
                {
                    $grupoitensItem = new GruposItens_Item();
                    $grupoitensItem->grupoItens_id = $model->id;
                    $grupoitensItem->item_id = $itens[$i];
                    $grupoitensItem->save();
                }

                return "Grupo Itens Criado com Sucesso";
            }
            else
            {
                throw new BadRequestHttpException("Por favor inserir itens");
            }

        }
        else{
            throw new BadRequestHttpException("Insira dados");
        }



    }

    public function actionDelete($id)
    {
        $model = Grupoitens::findOne(['id' => $id]);
        if($model != null)
        {
            $model->status = Grupoitens::STATUS_DELETED;
            $model->save();
        }
        else
        {
            throw new NotFoundHttpException("Grupo não encontrado");
        }
    }
}