<?php

namespace backend\modules\api\controllers;

use common\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{

    //TODO: Realmente fazer este controller. Implementação atual apenas para efeitos de teste

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


    public function actionIndex()
    {
        $users = User::find()->all();

        $users_clean = null;

        foreach ($users as $user)
        {
            $t['id'] = $user->id;
            $t['username'] = $user->username;
            $t['email'] = $user->email;
            $t['status'] = $user->status;
            $t['roles'] = Yii::$app->authManager->getRolesByUser($user->id);

            $users_clean[] = $t;
        }

        return $this->asJson(['status' => 200, 'users' => $users_clean]);
    }

}
