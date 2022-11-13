<?php

namespace backend\modules\api\controllers;

use common\models\Login;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class LoginController extends Controller
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

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['post'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        if($this->request->post('email') == null || $this->request->post('password') == null)
            $forcedStatus = 400; // Apenas para que a resposta devolvida cumpra convenção de estados HTTP.

        $loginModel = new Login();
        $loginModel->email = $this->request->post('email');
        $loginModel->password = $this->request->post('password');
        $loginModel->rememberMe = false;

        $token = $loginModel->APILogin();
        if($token)
        {
            return $this->asJson(['status' => 200, 'token' => $token]);
        }
        else
        {
            Yii::$app->response->statusCode = $forcedStatus ?? 403;
            return $this->asJson(['status' => $forcedStatus ?? 403, 'errors' => $loginModel->errors]);
        }
    }
}
