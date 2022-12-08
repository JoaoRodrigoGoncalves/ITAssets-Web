<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii\web\UnprocessableEntityHttpException;

class PedidoalocacaoController extends \yii\web\Controller
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
                // TODO: Dar acesso dependendo de ser ou não um pedido próprio
                throw new UnprocessableEntityHttpException("Não implementado");
                break;

            case "update":
                // TODO: Dar acesso dependendo de ser ou não um pedido próprio
                throw new UnprocessableEntityHttpException("Não implementado");
                break;

            case "delete":
                // TODO: Apenas poder cancelar o próprio
                if(!Yii::$app->user->can('cancelPedidoReparacao'))
                {
                    throw new ForbiddenHttpException();
                }
                break;

            default:
                throw new NotFoundHttpException();
        }
    }

}
