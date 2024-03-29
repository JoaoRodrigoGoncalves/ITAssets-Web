<?php

namespace backend\modules\api\controllers;

use common\models\Item;
use common\models\PedidoAlocacao;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ConflictHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class ItemController extends ActiveController
{
    public $modelClass = 'common\models\Item';

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

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['delete']);
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
            case "view":
                if(!Yii::$app->user->can('readItem'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "create":
            case "update":
            case "delete":
                if(!Yii::$app->user->can('writeItem'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

    public function actionIndex()
    {
        $this->checkAccess("index");
        return Item::findAll(['status' => Item::STATUS_ACTIVE]);
    }

    public function actionItensuser($user_id)
    {
        $this->checkAccess('index'); // Porque é baseado em index

        $authmgr = Yii::$app->authManager;
        $allowedRoles = [$authmgr->getRole('administrador')->name, $authmgr->getRole('operadorlogistica')->name];

        if(!(Yii::$app->user->id == $user_id || in_array(array_keys($authmgr->getRolesByUser(Yii::$app->user->id))[0], $allowedRoles)))
        {
            throw new ForbiddenHttpException();
        }

        $user = User::findOne($user_id);
        if($user != null)
        {
            $item_arr = [];
            foreach ($user->pedidosAlocacaoAsRequester as $pedido)
            {
                if($pedido->status == PedidoAlocacao::STATUS_APROVADO)
                {
                    $item_arr[] = $pedido->item;
                }
            }
            return $item_arr;
        }
        else
        {
            throw new NotFoundHttpException("Utilizador inválido");
        }
    }

    public function actionDelete($id)
    {
        $this->checkAccess("delete");
        $model = Item::findOne(['id' => $id]);
        if($model != null)
        {
            if(!$model->isInActiveItemsGroup() && !$model->isInActivePedidoAlocacao())
            {
                $model->status = Item::STATUS_DELETED;
                if($model->save())
                {
                    Yii::$app->getResponse()->setStatusCode(204);
                }
                else
                {
                    throw new ServerErrorHttpException("Erro ao guardar alterações");
                }
            }
            else
            {
                throw new ConflictHttpException("Não é possível apagar o item porque este se encontra em uso");
            }
        }
        else
        {
            throw new NotFoundHttpException("Item não encontrado");
        }
    }
}
