<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use backend\models\SetupForm;
use function PHPUnit\Framework\directoryExists;

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
        if (!Yii::$app->user->isGuest) {
            return $this->render('index');
        }else{
            return $this->redirect(Url::to(['login/index']));
        }

    }

    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest) {
            $model = new SetupForm();
            $roles = null; //TODO: verificar
            foreach (Yii::$app->authManager->getRoles() as $role)
                $roles[$role->name] = $role->name; //TODO: Trocar nome apresentado

            if ($this->request->isPost) {
                $model->load($this->request->post());
                $model->role = $this->request->post()['SetupForm']['role']; //TODO: ver disto

                if ($model->createUser(false)) {
                    return $this->redirect('index');
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'roles' => $roles,
                ]);
            }
        }
        else {
            return $this->redirect(Url::to(['login/index']));
        }

    }

}
