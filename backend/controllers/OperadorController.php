<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\models\User;
use backend\models\SetupForm;

class OperadorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [

                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new SetupForm();

        if ($this->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->createUser(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        /*if($this->request->isPost){

            if($model){
                return $this->redirect(Url::to(['login/index']));
            }
        }*/

    }

}
