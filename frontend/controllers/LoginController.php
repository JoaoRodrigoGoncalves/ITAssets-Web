<?php

namespace frontend\controllers;

use common\models\Login;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;

class LoginController extends \yii\web\Controller
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

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['dashboard/index']));
        }

        $auth = Yii::$app->authManager;

        $this->layout = 'main-no-session';

        $model = new Login();
        if($this->request->isPost)
        {
            $model->load(Yii::$app->request->post());

            if ($model->loginUser([$auth->getRole("funcionario")])) {
                return $this->redirect(Url::to(['dashboard/index']));
            }
        }
        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Url::to(['login/index']));
    }

}