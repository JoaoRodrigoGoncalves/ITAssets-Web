<?php

namespace backend\modules\api;

use Yii;
use yii\base\Module;
use yii\web\Response;

/**
 * api module definition class
 */
class ModuleAPI extends Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        //https://www.yiiframework.com/doc/guide/2.0/en/rest-authentication
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        Yii::$app->response->format = 'json';
        Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event)
        {
            $response = $event->sender;
            if (in_array($response->statusCode, [200, 201, 204])) {
                $response->data = [
                    'status' => $response->statusCode,
                    'data' => $response->data,
                ];
            }
            else
            {
                $response->data['status'] = $response->statusCode;

                if(!isset($response->data['message']) && isset($response->data['data']['message']))
                {
                    $response->data['message'] = $response->data['data']['message'];
                }
            }
        });
    }
}
