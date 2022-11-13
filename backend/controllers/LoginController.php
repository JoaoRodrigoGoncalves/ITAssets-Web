<?php

namespace backend\controllers;

use common\models\Login;
use backend\models\Utilizador;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;
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
                'class' => ErrorAction::class,
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

        $admins = $auth->getUserIdsByRole("administrador");
        if(count($admins) > 0)
        {
            $this->layout = 'main-login';

            $model = new Login();
            if($this->request->isPost)
            {
                $model->load(Yii::$app->request->post());

                if ($model->loginUser([$auth->getRole("administrador"), $auth->getRole("operadorLogistica")])) {
                    return $this->redirect(Url::to(['dashboard/index']));
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
        return $this->redirect(Url::to(['login/index']));
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

        $model = new Utilizador();

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