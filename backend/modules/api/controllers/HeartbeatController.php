<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;

class HeartbeatController extends Controller
{

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

    public function actionIndex()
    {
        return ['valid' => true];
    }

}
