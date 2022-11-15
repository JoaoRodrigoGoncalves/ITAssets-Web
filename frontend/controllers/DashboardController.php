<?php

namespace frontend\controllers;

use yii\base\Action;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
                        'roles' => ['funcionario']
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

    public function actionIndex(){
        $this->layout="main-frontofficie";

        return $this->render('index');
    }
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionPedidoReparacao(){

        return $this->render('PedidoReparacao');
    }

}