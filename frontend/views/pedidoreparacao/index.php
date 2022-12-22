<?php

use common\models\PedidoReparacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var PedidoReparacao[] $reparacao */

$this->title = 'Pedidos de Reparação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m-5">

    <h1 class="mb-5"><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-plus"></i> Pedido', ['create'], ['class' => 'btn btn-success float-right']) ?>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 1%; white-space: nowrap">Número Pedido</th>
                    <th>Data</th>

                    <th>Aprovador</th>
                    <th>Estado</th>
                    <th style="width: 1%"></th>
                </tr>
                </thead>
                <tbody>
                <?php if(count($reparacoes) > 0): ?>
                    <?php
                    foreach ($reparacoes as $reparacao): ?>
                        <tr>
                            <td><?= $reparacao->id ?></td>
                            <td><?= $reparacao->dataPedido ?></td>
                            <td><?= $reparacao->responsavel->username ?? "Por definir" ?></td>
                            <td><?= $reparacao->getPrettyStatus() ?></td>
                            <td style="white-space: nowrap">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['pedidoreparacao/view', 'id' => $reparacao->id], ['class' => 'btn btn-primary']) ?>
                                <?php if ($reparacao->status == 10): ?>
                                    <?= Html::a('<i class="fa fa-close"></i>', ['pedidoreparacao/cancel', 'id' => $reparacao->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
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
