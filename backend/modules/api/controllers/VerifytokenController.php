<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;

class VerifytokenController extends \yii\rest\Controller
{
    function behaviors()
    {
        $behaviors = parent::behaviors();
        //Verificar se o token enviado é igual ao do respetivo email
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    function actionIndex(){
        return null;
    }

}