<?php

namespace backend\modules\api\controllers;

use common\models\PedidoAlocacao;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii\web\UnprocessableEntityHttpException;

class PedidoalocacaoController extends ActiveController
{
    public $modelClass = 'common\models\PedidoAlocacao';

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
        unset($actions['delete']);
        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // Validar se o utilizador tem permissões para realizar a ação
        switch ($action)
        {
            case "index":
            case "create":
                if(!Yii::$app->user->can('createPedidoAlocacao'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "view":
                if(Yii::$app->user->can('createPedidoAlocacao'))
                {
                    // Apenas o proprio requerente e utilizadores com permissão para ver os pedidos de outros é que podem
                    // ver o pedido de alocação. Sendo assim, verificamos se o pedido de alocação indicado foi realizado
                    // pelo utilizador que fez o pedido à API. Se não foi, verificamos se o utilizador que fez o pedido à
                    // API tem permissão para ver os pedidos de outros utilizadores.

                    // Assumimos que o item existe porque esta parte só é executada depois da validação na ação
                    if(PedidoAlocacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null && !Yii::$app->user->can('readOthersPedidoAlocacao'))
                    {
                        throw new ForbiddenHttpException();
                    }
                }
                break;

            case "update":
                // Não existe edição dos dados de um pedido. Este método é usado para aprovar/negar/devolver um pedido
                if(!Yii::$app->user->can('changeStatusPedidoAlocacao'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            case "delete":
                if(Yii::$app->user->can('cancelPedidoAlocacao'))
                {
                    if(PedidoAlocacao::findOne(['id' => $params['id'], 'requerente_id' => Yii::$app->user->id]) == null)
                    {
                        throw new ForbiddenHttpException("Apenas o requerente pode cancelar o pedido");
                    }
                }
                else
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

    public function actionDelete($id)
    {
        $model = PedidoAlocacao::findOne(['id' => $id]);

        if($model != null)
        {
            $this->checkAccess("delete", null, ['id' => $id]);

            if($model->status == PedidoAlocacao::STATUS_ABERTO)
            {
                $model->status = 0;
                $model->save();
            }
            else
            {
                throw new BadRequestHttpException("Não é possível cancelar um pedido depois de processado");
            }
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado");
        }
    }
}
