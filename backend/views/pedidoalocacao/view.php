<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */

$this->title = 'Pedido de Alocação Nº' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos de Alocação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container flex-grow-1 container-p-y mt-3">
    <div class="card">
        <div class="card-header bg-info">
            <h2><?= Html::encode($this->title)?></h2>
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
                        <h4 class="font-weight-bold mb-0">Aprovador: <span class="text-muted font-weight-normal"><?= $model->aprovador->username ?? "<i>Não Aplicável</i>"?></span></h4>
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
                        <td>Item</td>
                        <td>
                            <?php
                                if($model->item != null)
                                {
                                    echo Html::a($model->item->nome, ['item/view', 'id' => $model->item->id]);
                                }
                                else
                                {
                                    echo Html::a($model->grupoItem->nome, ['grupoitens/view', 'id' => $model->grupoItem->id]);
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Observações</td>
                        <td><?= $model->obs ?? "<i>Não Aplicável</i>"?></td>
                    </tr>
                    <?php if($model->obsResposta != null): ?>
                        <tr>
                            <td>Resposta</td>
                            <td><?= $model->obsResposta?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <?php if($model->status == PedidoAlocacao::STATUS_APROVADO): ?>
                    <?= Html::a('Devolver', ['return', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>

                <?php if($model->status == PedidoAlocacao::STATUS_ABERTO): ?>
                    <?= Html::a('<i class="fas fa-thumbs-up"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
