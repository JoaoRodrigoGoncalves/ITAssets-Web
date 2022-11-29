<?php

namespace backend\controllers;


use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rbac\Role;
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
                        'roles' => ['readUtilizador']
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'activar', 'resetpassword'],
                        'allow' => true,
                        'roles' => ['writeUtilizador'],
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
        if(Yii::$app->user->can('writeUtilizador'))
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

        $roles = array();
        foreach (Yii::$app->authManager->getRoles() as $role)
            $roles[$role->name] = Utilizador::getRoleLabel($role->name);

        if ($this->request->isPost) {
            $model->load($this->request->post());

            if ($model->createUser()) {
                return $this->redirect(['utilizador/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $model = new Utilizador();

        // Carregar os valores atuais do utilizador para o modelo
        $model->setAttributes($user->attributes);
        // Carregar a role do utilizador, visto que não é um parametro padrão de User
        $model->role = $user->getRole();


        $roles = array();
        foreach (Yii::$app->authManager->getRoles() as $role) {
            $roles[$role->name] = Utilizador::getRoleLabel($role->name);
        }

        if ($this->request->isPost) {

            $model->load($this->request->post());
            if ($model->updateUser($id)) {
                return $this->redirect(['utilizador/index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    public function actionActivar($id)
    {
        if ($id != Yii::$app->user->id)
        {
            $model = $this->findModel($id);
            // Garantir que o utilizador em mãos está
            // ativado ou desativado. Desta forma não é
            // possível permitir ativar utilizadores eliminados
            if(in_array($model->status, [10, 9]))
            {
                if ($model->status == 10)
                {
                    $model->status = 9;
                }
                else
                {
                    $model->status = 10;
                }
                $model->save();
            }
        }
        else
        {
            Yii::$app->session->setFlash("error", "Não é possível desativar o utilizador atual");
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if($id != Yii::$app->user->id)
        {
            $model=$this->findModel($id);
            $model->status = 0;
            $model->save();
        }
        else
        {
            Yii::$app->session->setFlash("error", "Não é possível apagar o utilizador atual");
        }
        return $this->redirect(['index']);
    }

    public function actionResetpassword($id)
    {
        $user = $this->findModel($id);
        $user->setPassword("password123");
        $user->generateAuthKey();
        $user->save();
        $this->redirect(['utilizador/view', 'id' => $id]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
