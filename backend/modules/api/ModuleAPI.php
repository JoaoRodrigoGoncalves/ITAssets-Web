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
                // Se for uma resposta do tipo sucesso, organizar e enviar os dados
                // acrescentando o código de estado HTTP
                $response->data = [
                    'status' => $response->statusCode,
                    'data' => $response->data,
                ];
            }
            else
            {
                // Reestruturação da resposta caso não esteja no padrão de erro:
                // {
                //      "name": "",
                //      "message": "",
                //      "code": 0,
                //      "status": 5xx,
                //      "type": ""
                // }
                $response->data['status'] = $response->statusCode;

                if(!isset($response->data['message']) && isset($response->data['data']['message']))
                {
                    $response->data['message'] = $response->data['data']['message'];
                }
            }
        });
    }
}
