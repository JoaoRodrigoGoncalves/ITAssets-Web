<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['administrador', 'operadorLogistico']
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'main';
        return $this->render('index');
    }

}