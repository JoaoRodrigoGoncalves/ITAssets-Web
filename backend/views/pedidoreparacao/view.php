<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pedido-reparacao-view">

    <div class="container flex-grow-1 container-p-y mt-3">
        <div class="card">
            <div class="card-header bg-info">
                <h2>Nº de Pedido:<?= Html::encode($this->title)?></h2>
            </div>
            <div class="card-body">
                <div class="row no-gutters row-bordered">
                    <div class="d-flex col-md align-items-center">
                        <div class="card-body d-block text-body">
                            <h4 class="font-weight-bold mb-0">Requerente: <span class="text-muted font-weight-normal"><?= $model->requerente->username?></span></h4>
                            <div class="text-muted">Nº de Pedido: <?= $model->id?></div>
                            <div class="text-muted">Data de Pedido: <?= $model->dataPedido?></div>

                        </div>
                    </div>
                    <div class="d-flex col-md align-items-center"></div>
                    <div class="d-flex col-md align-items-center">
                        <div class="card-body d-block text-body">
                            <h4 class="font-weight-bold mb-0">Aprovador: <span class="text-muted font-weight-normal"><?= $model->responsavel->username ?? "<i>Não Aplicável</i>"?></span></h4>

                            <div class="text-muted mb-2">Status: <?= $model->getPrettyStatus()?></div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="card mb-4">
            <div class="card-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Data de Início</td>
                        <td><?= $model->dataInicio ?? "<i>Não Aplicável</i>"?></td>
                    </tr>
                    <tr>
                        <td>Data de Conclusão</td>
                        <td><?= $model->dataFim ?? "<i>Não Aplicável</i>" ?></td>
                    </tr>
                    <tr>
                        <td>Descrição do Problema</td>
                        <td><?= $model->descricaoProblema ?? "<i>Não Aplicável</i>" ?></td>
                    </tr>
                    <tr>
                        <?php
                        foreach ($model->linhaPedidoReparacaos as $linhaPedidoReparacao) {
                            echo " <tr>";
                            if($linhaPedidoReparacao->item == null)
                            {
                                echo "<td>Grupo de Itens</td>";
                                echo "<td>".Html::a($linhaPedidoReparacao->grupo->nome, ['grupoitens/view', 'id' => $linhaPedidoReparacao->grupo->id])."</td>";
                            }
                            else
                            {
                                echo "<td>Item</td>";
                                echo "<td>".Html::a($linhaPedidoReparacao->item->nome, ['item/view', 'id' => $linhaPedidoReparacao->item->id])."</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>





</div>



