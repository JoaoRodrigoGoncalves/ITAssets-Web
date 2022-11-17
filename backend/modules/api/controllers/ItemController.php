<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;

class ItemController extends ActiveController
{
    public $modelClass = 'common\models\Item';

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


}
