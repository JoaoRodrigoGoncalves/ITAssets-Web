<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class GrupoitensController  extends ActiveController
{
    public $modelClass = 'common\models\Grupoitens';

    public function behaviors()
    {
        $behaviors = parent::behaviors();-

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
        unset($actions['delete']);
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

    public function actionDelete($id)
    {
        $model = Grupoitens::findOne(['id' => $id]);
        if($model != null)
        {
            $model->status = 0;
            $model->save();
        }
        else
        {
            throw new NotFoundHttpException("Grupo não encontrado");
        }
    }
}