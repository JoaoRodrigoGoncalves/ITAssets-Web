<?php

namespace frontend\controllers;

use common\models\Notificacoes;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
                        'actions' => ['index', 'marcarlido'],
                        'allow' => true,
                        'roles' => ['funcionario']
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

    public function actionIndex(){
        $dataProvider = new ActiveDataProvider([
            'query' => Notificacoes::find()->where(['user_id' => Yii::$app->user->id])
        ]);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMarcarlido()
    {
        Notificacoes::updateAll(
            ['read' => true],
            ['user_id' => Yii::$app->user->id]
        );

        if(!$this->request->isAjax)
        {
            return $this->redirect(['dashboard/index']);
        }
    }
}