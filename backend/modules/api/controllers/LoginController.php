<?php

namespace backend\modules\api\controllers;

use common\models\Login;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

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
                'index' => ['get'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $headers = Yii::$app->request->headers;

        if($headers->has('Authorization'))
        {
            $loginModel = new Login();
            $loginModel->email = Yii::$app->request->authCredentials[0];
            $loginModel->password = Yii::$app->request->authCredentials[1];
            $loginModel->rememberMe = false;

            $token = $loginModel->APILogin();
            if($token)
            {
                $user = User::findIdentityByAccessToken($token);
                $role = array_values(Yii::$app->authManager->getRolesByUser($user->id))[0];
                return $this->asJson(['token' => $token, 'username' => $user->username, 'email' => $user->email, 'level' => $role->name]);
            }
            else
            {
                throw new UnauthorizedHttpException("Credenciais inválidas");
            }
        }
        else
        {
            throw new BadRequestHttpException("Credenciais em falta");
        }
    }
}
