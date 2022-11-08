<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use backend\models\SetupForm;
use yii\web\NotFoundHttpException;
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

                        'actions' => ['index','create','update'],
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
            $utilizador = User::find()->all();

            return $this->render('index', ['utilizador' => $utilizador]);
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

    /**
     * Updates an existing operador model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found

    public function actionUpdate($id)
    {

        $roles = null; //TODO: verificar
        foreach (Yii::$app->authManager->getRoles() as $role)
            $roles[$role->name] = $role->name; //TODO: Trocar nome apresentado


        $model = $this->findModel($id);
        $model->role=Yii::$app->authManager->getUserIdsByRole($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }



     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SetupForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found

    protected function findModel($id)
    {

        if (($user = User::findOne(['id' => $id])) !== null) {


            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }*/

}
