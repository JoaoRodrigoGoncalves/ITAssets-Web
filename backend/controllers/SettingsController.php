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
                    //TODO: bloquear utilizador padrão de entrar aqui
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['ConsultarPropriaConta']
                    ],
                    [
                        'actions' => ['save', 'password'],
                        'allow' => true,
                        'roles' => ['EditarPropriaConta']
                    ]
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
                'class' => \yii\web\ErrorAction::class,
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
                $this->redirect(Url::to(['settings/index']));
            }
            else
            {
                // TODO: Erro validação falhou. Como passar para lá devolta?
                // Talvez usar o addError ao $user e renderizar a index mesmo no /save
            }
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