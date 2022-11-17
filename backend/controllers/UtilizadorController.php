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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['VerDetalhesUtilizador']
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['RegistarUtilizador'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['EditarUtilizador'],
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

    public function actionView($id)
    {
        if(in_array(Yii::$app->authManager->getRole("administrador"), Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)))
        {
            $user = User::findOne(['id' => $id]);
        }
        else
        {
            $user = User::findOne(['id' => $id, 'status' => 10]);
        }

        if($user != null)
        {
            return $this->render('view', ['utilizador' => $user]);
        }
        else
        {
            throw new NotFoundHttpException();
        }
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
