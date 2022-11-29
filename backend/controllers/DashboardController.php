<?php

namespace backend\controllers;

use common\models\Empresa;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;

class DashboardController extends Controller
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
                        'roles' => ['administrador', 'operadorLogistica']
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {

        $empresa = Empresa::findOne(['id' => 1]);

        if(!$empresa)
        {
            return $this->redirect(Url::to(['empresa/create']));
        }

        $this->layout = 'main';
        return $this->render('index');
    }

}