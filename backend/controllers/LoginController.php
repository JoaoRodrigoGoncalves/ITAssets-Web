<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Login controller
 */
class LoginController extends Controller
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
                        'actions' => ['index', 'setup'], // setup para configurar a primeira conta de administrador
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
     * {@inheritdoc}
     */
    public function actions()
    {
        // CHECKLATER: Não me cheira que seja para aqui
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
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
            return $this->goHome();
        }

        $admins = Yii::$app->authManager->getUserIdsByRole("administrador");

        if(count($admins) > 0)
        {
            $this->layout = 'main-login';

            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }

            $model->password = '';

            return $this->render('index', [
                'model' => $model,
            ]);
        }
        else
        {
            return $this->redirect('setup');
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Setup action
     * @return string|Response
     */
    public function actionSetup()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        //CHECKLATER: Se é preciso passar um model

        return $this->render('setup', [
            'model' => new SetupForm()
        ]);
    }
}