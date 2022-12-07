<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var PedidoAlocacao[] $pedidos */

$this->title = 'Pedidos de Alocação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m-5">

    <h1 class="mb-5"><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-header">
            <?= Html::a('Novo pedido de alocação', ['create'], ['class' => 'btn btn-success float-right']) ?>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 1%; white-space: nowrap">Número Pedido</th>
                        <th>Data</th>
                        <th>Objeto</th>
                        <th>Aprovador</th>
                        <th>Estado</th>
                        <th style="width: 1%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($pedidos) > 0): ?>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= $pedido->id ?></td>
                                <td><?= $pedido->dataPedido ?></td>
                                <td><?= $pedido->item->nome ?? $pedido->grupoItem->nome ?></td>
                                <td><?= $pedido->aprovador->username ?? "N/A" ?></td>
                                <td><?= $pedido->getPrettyStatus() ?></td>
                                <td style="white-space: nowrap">
                                    <?= Html::a('<i class="fa fa-eye"></i>', ['pedidoalocacao/view', 'id' => $pedido->id], ['class' => 'btn btn-primary']) ?>
                                    <!-- TODO: Ver se isto é para manter aqui. Depende de como for implementado no backoffice -->
                                    <?php if ($pedido->status == 10): ?>
                                        <?= Html::a('<i class="fa fa-close"></i>', ['pedidoalocacao/delete', 'id' => $pedido->id], ['class' => 'btn btn-danger']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Sem dados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
