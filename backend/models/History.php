<?php

namespace backend\models;

use common\models\PedidoAlocacao;
use DateTime;
use yii\data\ArrayDataProvider;

class History
{
    public DateTime $data;
    public string $message;


    public function getItemHistory($id)
    {
        return self::processData(PedidoAlocacao::findAll(['item_id' => $id]));
    }

    public function getGroupHistory($id)
    {
        return self::processData(PedidoAlocacao::findAll(['grupoItem_id' => $id]));
    }

    private function processData($model)
    {
        $eventos = array();

        foreach($model as $pedido)
        {
            // Todos os pedidos começam por ser do status Aberto
            $auxArray['date'] = $pedido->dataPedido;
            $auxArray['pedido_id'] = $pedido->id;
            $auxArray['user'] = (object)['id' => $pedido->requerente_id, 'username' => $pedido->requerente->username];
            $auxArray['type'] = PedidoAlocacao::STATUS_ABERTO;
            $eventos[] = (object)$auxArray;

            $auxArray = null;

            switch($pedido->status)
            {

                case PedidoAlocacao::STATUS_APROVADO:
                    $auxArray['date'] = $pedido->dataInicio;
                    $auxArray['pedido_id'] = $pedido->id;
                    $auxArray['user'] = (object)['id' => $pedido->aprovador_id, 'username' => $pedido->aprovador->username];
                    $auxArray['type'] = PedidoAlocacao::STATUS_APROVADO;
                    $eventos[] = (object)$auxArray;

                case PedidoAlocacao::STATUS_NEGADO:
                    $auxArray['date'] = $pedido->dataInicio;
                    $auxArray['pedido_id'] = $pedido->id;
                    $auxArray['user'] = (object)['id' => $pedido->aprovador_id, 'username' => $pedido->aprovador->username];
                    $auxArray['type'] = PedidoAlocacao::STATUS_NEGADO;
                    $eventos[] = (object)$auxArray;
                    break;

                case PedidoAlocacao::STATUS_DEVOLVIDO:
                    $auxArray['date'] = $pedido->dataInicio;
                    $auxArray['pedido_id'] = $pedido->id;
                    $auxArray['user'] = (object)['id' => $pedido->aprovador_id, 'username' => $pedido->aprovador->username];
                    $auxArray['type'] = PedidoAlocacao::STATUS_APROVADO;
                    $eventos[] = (object)$auxArray;

                    $auxArray['date'] = $pedido->dataFim;
                    $auxArray['pedido_id'] = $pedido->id;
                    $auxArray['type'] = PedidoAlocacao::STATUS_DEVOLVIDO;
                    $eventos[] = (object)$auxArray;
                    break;

                case PedidoAlocacao::STATUS_CANCELADO:
                    $auxArray['date'] = $pedido->dataInicio;
                    $auxArray['pedido_id'] = $pedido->id;
                    $auxArray['user'] = (object)['id' => $pedido->requerente_id, 'username' => $pedido->requerente->username];
                    $auxArray['type'] = PedidoAlocacao::STATUS_CANCELADO;
                    $eventos[] = (object)$auxArray;
                    break;
            }
        }

        usort($eventos, function($a, $b){
            $timediff = strtotime($b->date) - strtotime($a->date);

            if($timediff == 0 && $a->pedido_id == $b->pedido_id)
            {
                /* Esta condução é mais para quando um item é alocado administrativamente a um utilizador
                 * para que a ordem abaixo seja respeitada.
                 * Aberto = 10
                 * Aprovado = 9
                 * Negado = 8
                 * Devolvido = 7
                 * Cancelado = 0
                 */
                return $a->type - $b->type;
            }
            else
            {
                return $timediff;
            }
        });

        return new ArrayDataProvider([
            'allModels' => $eventos,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }
}