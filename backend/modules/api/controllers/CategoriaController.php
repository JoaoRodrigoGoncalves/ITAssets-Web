<?php

namespace backend\modules\api\controllers;

use common\models\Categoria;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ConflictHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class CategoriaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

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
            'class' => HttpBearerAuth::class
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
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
            case "view":
                if(!Yii::$app->user->can('readCategoria'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            case "create":
            case "update":
            case "delete":
                if(!Yii::$app->user->can('writeCategoria'))
                {
                    throw new ForbiddenHttpException();
                }
            break;

            default:
                throw new NotFoundHttpException($action . " desconhecido");
        }
    }

    public function actionDelete($id)
    {
        $model = Categoria::findOne(['id' => $id]);
        if($model != null)
        {
            if(count($model->items) > 0)
            {
                $model->status = Categoria::STATUS_DELETED;
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
                throw new ConflictHttpException("A Categoria está em uso.");
            }
        }
        else
        {
            throw new NotFoundHttpException("Categoria não encontrada");
        }
    }
}
