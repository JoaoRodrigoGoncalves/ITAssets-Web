<?php

namespace backend\modules\api\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class LoginController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if($this->request->isPost)
        {
            return "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        }
        return "bbbbbbb";
    }
}
