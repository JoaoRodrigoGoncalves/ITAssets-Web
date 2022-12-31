<?php

namespace backend\models;

use common\models\PedidoAlocacao;
use common\models\PedidoReparacao;
use DateTime;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class History
{
    public string $data; //Data do evento
    public string $message; //Mensagem descritiva do evento
    protected int $idPedido; // Usado para dessambiguar a ordem de eventos
    protected int $status; // Status dessambiguador

    public function getItemHistory($itemId): ArrayDataProvider
    {
        $eventos = $this->processPedidoAlocacao(PedidoAlocacao::findAll(['item_id' => $itemId]));

        $aux_reparacao = PedidoReparacao::find()->innerJoin('linha_pedido_reparacao', 'linha_pedido_reparacao.pedido_id = pedido_reparacao.id') -> where(['item_id' => $itemId,])-> all();
        $reparacao = $this->processPedidoReparacao(PedidoReparacao::findAll(['id' => $aux_reparacao]));

        //TODO: Escrever algo deste genero quando for para implementar o ITASSETS-53 (Isto é código não funcional, apenas exemplo)
        $eventos = array_merge($eventos, $reparacao);

        return new ArrayDataProvider([
            'allModels' => $this->sortEvents($eventos),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

    public function getGroupHistory($groupID): ArrayDataProvider
    {
        $eventos = $this->processPedidoAlocacao(PedidoAlocacao::findAll(['grupoItem_id' => $groupID]));
        $aux_reparacao = PedidoReparacao::find()->innerJoin('linha_pedido_reparacao', 'linha_pedido_reparacao.pedido_id = pedido_reparacao.id') -> where(['grupo_id' => $groupID,])-> all();
        $reparacao = $this->processPedidoReparacao(PedidoReparacao::findAll(['id' => $aux_reparacao]));

        //TODO: Escrever algo deste genero quando for para implementar o ITASSETS-53 (Isto é código não funcional, apenas exemplo)
        $eventos = array_merge($eventos, $reparacao);

        return new ArrayDataProvider([
            'allModels' => $this->sortEvents($eventos),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

    private function processPedidoAlocacao($model): array
    {
        $eventos = array();

        foreach($model as $pedido)
        {
            // Todos os pedidos começam por ser do status Aberto
            $aux = new History();
            $aux->data = $pedido->dataPedido;
            $aux->idPedido = $pedido->id;
            $aux->status = PedidoAlocacao::STATUS_ABERTO;
            $aux->message = "O " . Html::a("Pedido Alocação Nº{$pedido->id}", ['pedidoalocacao/view', 'id' => "{$pedido->id}"]) .
                            " foi aberto por/para " .
                            Html::a($pedido->requerente->username, ['utilizador/view', 'id' => $pedido->requerente_id]) . ".";
            $eventos[] = $aux;

            switch($pedido->status)
            {
                case PedidoAlocacao::STATUS_NEGADO:
                    $aux = new History();
                    $aux->data = $pedido->dataInicio;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoAlocacao::STATUS_NEGADO;
                    $aux->message = "O " . Html::a("Pedido Alocação Nº{$pedido->id}", ['pedidoalocacao/view', 'id' => "{$pedido->id}"]) .
                                    " foi negado por " .
                                    Html::a($pedido->aprovador->username, ['utilizador/view', 'id' => $pedido->aprovador_id]) . ".";
                    $eventos[] = $aux;
                    break;

                case PedidoAlocacao::STATUS_DEVOLVIDO:
                    $aux = new History();
                    $aux->data = $pedido->dataFim;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoAlocacao::STATUS_DEVOLVIDO;
                    $aux->message = "O item foi marcado como devolvido no " .
                                    Html::a("Pedido Alocação Nº{$pedido->id}", ['pedidoalocacao/view', 'id' => "{$pedido->id}"]);
                    $eventos[] = $aux;
                    //Fall through intencional

                case PedidoAlocacao::STATUS_APROVADO:
                    $aux = new History();
                    $aux->data = $pedido->dataInicio;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoAlocacao::STATUS_APROVADO;
                    $aux->message = "O " . Html::a("Pedido Alocação Nº{$pedido->id}", ['pedidoalocacao/view', 'id' => "{$pedido->id}"]) .
                        " foi aprovado por " .
                        Html::a($pedido->aprovador->username, ['utilizador/view', 'id' => $pedido->aprovador_id]) . ".";
                    $eventos[] = $aux;
                    break;

                case PedidoAlocacao::STATUS_CANCELADO:
                    $aux = new History();
                    $aux->data = $pedido->dataInicio;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoAlocacao::STATUS_CANCELADO;
                    $aux->message = "O " . Html::a("Pedido Alocação Nº{$pedido->id}", ['pedidoalocacao/view', 'id' => "{$pedido->id}"]) .
                                    " foi cancelado pelo requerente.";
                    $eventos[] = $aux;
                    break;
            }
        }
        return $eventos;
    }

    private function processPedidoReparacao($model): array
    {
        $reparacao = array();

        foreach($model as $pedido)
        {
            // Todos os pedidos começam por ser do status Aberto
            $aux = new History();
            $aux->data = $pedido->dataPedido;
            $aux->idPedido = $pedido->id;
            $aux->status = PedidoReparacao::STATUS_ABERTO;
            $aux->message = "O " . Html::a("Pedido de Reparação Nº{$pedido->id}", ['pedidoreparacao/view', 'id' => "{$pedido->id}"]) .
                " foi aberto por/para " .
                Html::a($pedido->requerente->username, ['utilizador/view', 'id' => $pedido->requerente_id]) . ".";
            $reparacao[] = $aux;

            switch($pedido->status) {
                case PedidoReparacao::STATUS_EM_REVISAO:
                    $aux = new History();
                    $aux->data = $pedido->dataPedido;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoReparacao::STATUS_EM_REVISAO;
                    $aux->message = "O " . Html::a("Pedido de Reparação Nº{$pedido->id}", ['pedidoreparacao/view', 'id' => "{$pedido->id}"]) .
                        " foi marcado em revisão por " .
                        Html::a($pedido->responsavel->username, ['utilizador/view', 'id' => $pedido->responsavel_id]) . ".";
                    $reparacao[] = $aux;
                    break;

                case PedidoReparacao::STATUS_CONCLUIDO:
                    $aux = new History();
                    $aux->data = $pedido->dataFim;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoReparacao::STATUS_CONCLUIDO;
                    $aux->message = "O item foi marcado como concluído no " .
                        Html::a("Pedido de Reparação Nº{$pedido->id}", ['pedidoreparacao/view', 'id' => "{$pedido->id}"]);
                    $reparacao[] = $aux;
                    break;

                case PedidoReparacao::STATUS_CANCELADO:
                    $aux = new History();
                    $aux->data = $pedido->dataInicio;
                    $aux->idPedido = $pedido->id;
                    $aux->status = PedidoReparacao::STATUS_CANCELADO;
                    $aux->message = "O " . Html::a("Pedido de Reparação Nº{$pedido->id}", ['pedidoreparacao/view', 'id' => "{$pedido->id}"]) .
                        " foi cancelado pelo requerente.";
                    $reparacao[] = $aux;
                    break;
            }
        }
        return $reparacao;
    }

    private function sortEvents(array $array): array
    {
        usort($array, function($a, $b){
            $timediff = strtotime($b->data) - strtotime($a->data);

            if($timediff == 0 && $a->idPedido == $b->idPedido)
            {
                /* Esta condição é mais para quando um item é alocado administrativamente a um utilizador.
                 * Neste caso, ordenamos pelo status, sendo que o status com o maior valor absoluto aparece à frente
                 * de um com um menor valor.
                 */
                return $a->status - $b->status;
            }
            else
            {
                return $timediff;
            }
        });
        return $array;
    }
}