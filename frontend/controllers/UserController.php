<?php

namespace frontend\controllers;

use frontend\models\ChangePasswordForm;
use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
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
                $this->redirect(Url::to(['user/index']));
            }
            else
            {
                // TODO: Erro validação falhou. Como passar para lá devolta?
                // Talvez usar o addError ao $user e renderizar a index mesmo no /save
            }
        }
        else
        {
            $this->redirect(Url::to(['user/index']));
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
        $this->redirect(Url::to(['user/index']));
    }

}
