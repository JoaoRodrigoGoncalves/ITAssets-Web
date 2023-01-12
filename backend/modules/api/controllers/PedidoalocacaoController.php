<?php

namespace backend\modules\api\controllers;

use common\models\Grupoitens;
use common\models\Item;
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
        unset($actions['delete'], $actions['update'], $actions['create']);
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

    public function actionCreate(){
        //Cria um Novo Pedido de Alocação
        $model = new PedidoAlocacao();

        $this->checkAccess("create", null);

        $data = Yii::$app->getRequest()->getBodyParams();

        //Verifica se foi inserido um aprovador e guarda o status: caso inserido o estado é aprovado, caso não inserido o estado é aberto
        if(isset($data['aprovador_id'])){
            $model->status = PedidoAlocacao::STATUS_APROVADO;
        }else{
            $model->status = PedidoAlocacao::STATUS_ABERTO;
        }

        //Guarda os seguintes campos
        $model->requerente_id = $data['requerente_id'];
        $model->aprovador_id = $data['aprovador_id'];
        $model->obs = $data['obs'];
        $model->obsResposta = $data['obsResposta'];

        //Valida se foi colocado um item e um grupo no mesmo pedido: caso aconteça tem de dar erro
        if(isset($data['item_id']) && isset($data['grupoItem_id'])){
            throw new BadRequestHttpException("Não é possível selecionar um item e um grupo de itens ");
        }

        //Valida se o item exite na base de dados
        //Valida se o item não está associado num grupo de itens nem alocado
        if(isset($data['item_id'])){
            $item = Item::findOne($data['item_id']);

            //ve se o item existe na bd
            if ($item != null) {
                //O Item não pode estar num grupo de itens nem alocado
                if (!$item->isInActiveItemsGroup() && !$item->isInActivePedidoAlocacao()) {
                    $model->item_id = $data['item_id'];
                    $model->grupoItem_id = null;

                    $model->save();
                    return $model;
                } else {
                    throw new BadRequestHttpException("O Item não pode estar associado a um Grupo de itens e nem Alocado");
                }
            }
            else{
                throw new BadRequestHttpException("O Item não existe");
            }
        }
        //Valida se o grupo de itens exite na base de dados
        //Valida se o grupo de itens não está alocado
        elseif(isset($data['grupoItem_id'])){
            $grupoItens = Grupoitens::findOne($data['grupoItem_id']);

            //ve se o grupo de itens existe na bd
            if ($grupoItens != null) {
                //O Grupo de Itens não pode estar alocado
                if (!$grupoItens->isinActivePedidoAlocacao()) {
                    $model->item_id = null;
                    $model->grupoItem_id = $data['grupoItem_id'];

                    $model->save();
                    return $model;
                } else {
                    throw new BadRequestHttpException("O Grupo de Item não pode estar Alocado");
                }
            }
            else{
                throw new BadRequestHttpException("O Grupo de Itens não existe");
            }
        }
    }

    public function actionUpdate($id){
        $model = PedidoAlocacao::findOne(['id' => $id]);

        if($model != null)
        {
            $this->checkAccess("update", null, ['id' => $id]);
            $data = Yii::$app->getRequest()->getBodyParams();

            switch ($data['status']){
                /** Caso o status seja igual a 9, ou seja, APROVADO **/
                case PedidoAlocacao::STATUS_APROVADO:
                    if($model->status == PedidoAlocacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoAlocacao::STATUS_APROVADO;
                        $model->aprovador_id = $data['aprovador_id'];
                        $model->obsResposta = $data['obsResposta'];
                        $model->save();
                    }
                    else{
                        throw new BadRequestHttpException("Não é possível aprovar um pedido depois de processado");
                    }
                    break;

                /** Caso o status seja igual a 7, ou seja, DEVOLVIDO **/
                case PedidoAlocacao::STATUS_DEVOLVIDO:
                    if($model->status == PedidoAlocacao::STATUS_APROVADO)
                    {
                        $model->status = PedidoAlocacao::STATUS_DEVOLVIDO;
                        $model->save();
                    }
                    else
                    {
                        throw new BadRequestHttpException("Não é possível devolver um pedido depois de processado");
                    }
                    break;

                /** Caso o status seja igual a 0, ou seja, CANCELADO **/
                case PedidoAlocacao::STATUS_CANCELADO:
                    if($model->status == PedidoAlocacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoAlocacao::STATUS_NEGADO;
                        $model->save();
                    }
                    else
                    {
                        throw new BadRequestHttpException("Não é possível cancelar um pedido depois de processado");
                    }
                    break;

                /** Caso o status seja igual a 8, ou seja, NEGADO **/
                case PedidoAlocacao::STATUS_NEGADO:
                    if($model->status == PedidoAlocacao::STATUS_ABERTO)
                    {
                        $model->status = PedidoAlocacao::STATUS_NEGADO;
                        $model->aprovador_id = $data['aprovador_id'];
                        $model->obsResposta = $data['obsResposta'];
                        $model->save();
                    }
                    else
                    {
                        throw new BadRequestHttpException("Não é possível negar um pedido depois de processado");
                    }
                    break;
            }
            return $model;
        }
        else
        {
            throw new NotFoundHttpException("Pedido de Alocação não encontrado");
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
                $model->status = PedidoAlocacao::STATUS_CANCELADO;
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
