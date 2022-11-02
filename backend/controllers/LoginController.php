<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use backend\models\SetupForm;
use PHPUnit\TextUI\XmlConfiguration\UpdateSchemaLocationTo93;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
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
            if($this->request->isPost){
                $model->load(Yii::$app->request->post());
                if ($model->login()) {
                    dd("sessão");
                    return $this->goBack();
                }
            }

            $model->password = '';

            return $this->render('index', [
                'model' => $model,
            ]);
        }
        else
        {
            return $this->redirect(Url::to(['login/setup']));
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

        $model = new SetupForm();

        if($this->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->setupFirstAdmin()){
                return $this->redirect(Url::to(['login/index']));
            }
        }

        $model->password = "";
        $this->layout = 'main-login';

        return $this->render('setup', [
            'model' => $model,
        ]);
    }
}