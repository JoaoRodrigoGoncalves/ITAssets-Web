<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use backend\models\Utilizador;
use yii\web\NotFoundHttpException;
use function PHPUnit\Framework\directoryExists;

class UtilizadorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['administrador'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $utilizadores = User::find()->all();
        return $this->render('index', ['utilizadores' => $utilizadores]);
    }

    public function actionCreate()
    {
        $model = new Utilizador();
        $roles = null; //TODO: verificar

        foreach (Yii::$app->authManager->getRoles() as $role)
            $roles[$role->name] = Utilizador::getRoleLabel($role->name);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            if ($model->createUser()) {
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles,
            ]);
        }
    }
}