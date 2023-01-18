<?php

namespace backend\modules\api\controllers;

use backend\models\Utilizador;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['formats'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
                'view' => ['get'],
                'create' => ['post'],
                'update' => ['put'],
                'delete' => ['delete']
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions =  parent::actions();
        unset($actions['create']);

        return $actions;
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
            case "view":
                if(!Yii::$app->user->can('readUtilizador'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "create":
            case "update":
            case "delete":
                if(!Yii::$app->user->can('writeUtilizador'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

    public function actionCreate()
    {
        $this->checkAccess('create');

        $data = Yii::$app->getRequest()->getBodyParams();

        if(!isset($data['username'], $data['email']))
        {
            throw new UnprocessableEntityHttpException("Campos \"username\" e \"email\" obrigatórios.");
        }

        $model = new Utilizador();
        $model->username = $data['username'];
        $model->email = $data['email'];

        if(isset($data['role']))
        {
            if(in_array($data['role'], ['funcionario', 'operadorLogistica', 'administrador']))
            {
                $model->role = $data['role'];
            }
            else
            {
                throw new BadRequestHttpException("Role indicada inválida");
            }
        }
        else
        {
            $model->role = "funcionario";
        }

        $preAtivar = false;

        if(isset($data['preAtivar']))
        {
            if($data['preAtivar'] === true)
            {
                $preAtivar = true;
            }
        }

        if($model->createUser($preAtivar))
        {
            return User::findOne(['email' => $data['email']]);
        }
        else
        {
            throw new ServerErrorHttpException("Não foi possível guardar os dados.");
        }
    }

    public function actionUpdate($id)
    {
        $this->checkAccess('update');

        $user = User::findOne($id);

        if($user != null)
        {
            $data = Yii::$app->getRequest()->getBodyParams();

            if(isset($data['username']))
            {
                $user->username = $data['username'];
            }

            if(isset($data['email']))
            {
                $user->email = $data['email'];
            }

            if(isset($data['role']))
            {
                if(in_array($data['role'], ['funcionario', 'operadorLogistica', 'administrador']))
                {
                    $mrg = Yii::$app->authManager;
                    $mrg->revokeAll($id);
                    $mrg->assign($mrg->getRole($data['role']), $id);
                }
                else
                {
                    throw new BadRequestHttpException("Role indicada inválida");
                }
            }

            if($user->save())
            {
                return User::findOne($id);
            }
            else
            {
                throw new ServerErrorHttpException("Não foi possível guardar os dados");
            }
        }
        else
        {
            throw new NotFoundHttpException("Utilizador não encontrado");
        }
    }

}
