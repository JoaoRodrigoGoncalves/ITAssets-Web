<?php

namespace backend\controllers;

use backend\models\ChangePasswordForm;
use Cassandra\Set;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;

class SettingsController extends Controller
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
                        'actions' => ['index', 'save', 'password'],
                        'allow' => true,
                        // Fazemos filtragem por role visto que queremos
                        // que só os utilizadores com acesso ao backoffice
                        // consigam fazer a edição das suas contas no backoffice
                        'roles' => ['administrador', 'operadorLogistica']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'save' => ['post'],
                    'password' => ['post'],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Nome do Utilizador',
            'email' => 'E-Mail',
            'passowrd' => "Palavra-passe"
        ];
    }

    public function actionIndex()
    {
        $this->layout = "main";
        $user = User::findOne(['id' => Yii::$app->user->id]);

        $password = new ChangePasswordForm();

        if(Yii::$app->session->hasFlash('error_old_password'))
            $password->addError('old_password', Yii::$app->session->getFlash('error_old_password'));

        return $this->render('index', ['user' => $user, 'password' => $password]);
    }

    public function actionSave()
    {
        if($this->request->isPost)
        {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            $user->load($this->request->post());
            if($user->validate())
            {
                $user->save();
                Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Erro de validação');
            }
            $this->redirect(Url::to(['settings/index']));
        }
        else
        {
            $this->redirect(Url::to(['settings/index']));
        }
    }

    public function actionPassword()
    {
        if($this->request->isPost)
        {
            $settings = new ChangePasswordForm();
            $settings->load($this->request->post());
            $settings->updatePassword(); // Não é necessário confirmar se foi possível atualizar porque a prórpia função já guarda um flash para isso
        }
        $this->redirect(Url::to(['settings/index']));
    }

}