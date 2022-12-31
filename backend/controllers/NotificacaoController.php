<?php

namespace backend\controllers;

use common\models\Notificacoes;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class NotificacaoController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'marcarlido'],
                            'allow' => true,
                            'roles' => ['administrador', 'operadorLogistica']
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Notificacoes::find()
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index',
        [
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
            return $this->redirect(['notificacao/index']);
        }
    }
}
