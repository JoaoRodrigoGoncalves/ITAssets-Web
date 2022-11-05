<?php

namespace backend\controllers;

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
                    [
                        'actions' => ['index', 'save', 'update'],
                        'allow' => true,
                        'roles' => ['administrador', 'operadorLogistico']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'save' => ['post'],
                    'update' => ['post'],
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
        return $this->render('index', ['user' => $user]);
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
                $this->redirect(Url::to(['settings/index']));
            }
            else
            {
                // TODO: Erro validação falhou? Como passar para lá devolta?
                // Talvez usar o addError ao $user e renderizar a index mesmo no /save
            }
        }
        else
        {
            $this->redirect(Url::to(['settings/index']));
        }
    }

    public function actionUpdate()
    {
        if($this->request->isPost)
        {
            dd($this->request);
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->validatePassword($this->request->old_password))
            {
                //TODO: Validar password (termos de comprimento e segurança) antes de a trocar
                $user->setPassword($this->request->new_password);
                $user->save();
                $this->redirect(Url::to(['settings/index']));
            }
            else
            {
                //TODO: Old_password não é igual à atual. Como passar erro
                //$user->addError(); mayhaps?
                echo "DEBUG: Password errada";
            }
        }
        else
        {
            $this->redirect(Url::to(['settings/index']));
        }
    }

}