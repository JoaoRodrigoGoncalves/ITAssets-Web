<?php

use common\models\PedidoReparacao;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */

$this->title = "Pedido Reparação Nº" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos de Reparação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-reparacao-view ms-5 me-5 mt-2">
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
                        <h4 class="font-weight-bold mb-0">Responsável: <span class="text-muted font-weight-normal"><?= $model->responsavel->username ?? "<i>Não Aplicável</i>"?></span></h4>
                        <div class="text-muted mb-2">Status: <?= $model->getPrettyStatus()?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if(in_array($model->status, [PedidoReparacao::STATUS_EM_REVISAO, PedidoReparacao::STATUS_ABERTO, PedidoReparacao::STATUS_EM_PREPARACAO]))
            {
                echo '<div class="card-footer">';

                echo match ($model->status)
                {
                    PedidoReparacao::STATUS_EM_PREPARACAO => Html::a("Cancelar Pedido", ['pedidoreparacao/cancelar', 'id' => $model->id], ['class' => 'btn btn-danger float-right']),
                    PedidoReparacao::STATUS_ABERTO => Html::a("Tornar-se Responsável", ['pedidoreparacao/selfassign', 'id' => $model->id], ['class' => 'btn btn-success float-right']),
                    PedidoReparacao::STATUS_EM_REVISAO => Html::a('Finalizar', ['pedidoreparacao/finalizar', 'id' => $model->id], ['class' => 'btn btn-success float-right']),
                };

                echo '</div>';
            }
        ?>
    </div>

    <div class="row mb-4">
        <div class="col-sm">
            <div class="card h-100">
                <div class="card-header font-weight-bold">Detalhes</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><b>Data de Início:</b></td>
                                <td><?= $model->dataInicio ?? "<i>Não Aplicável</i>"?></td>
                            </tr>
                            <tr>
                                <td><b>Data de Conclusão:</b></td>
                                <td><?= $model->dataFim ?? "<i>Não Aplicável</i>" ?></td>
                            </tr>
                            <tr>
                                <td style="width: 1%; white-space: nowrap;"><b>Descrição do problema:</b></td>
                                <td><?= $model->descricaoProblema ?? "<i>Não Aplicável</i>" ?></td>
                            </tr>
                            <?php if($model->status == PedidoReparacao::STATUS_CONCLUIDO): ?>
                                <tr>
                                    <td style="width: 1%; white-space: nowrap;"><b>Detalhes da reparação:</b></td>
                                    <td>
                                        <?= $model->respostaObs ?? "<i>Nada foi indicado pelo responsável.</i>" ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card h-100">
                <div class="card-header font-weight-bold">Objetos</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Objeto</th>
                                <th>Data de alocação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($model->linhasPedidoReparacao) > 0): ?>
                                <?php foreach ($model->linhasPedidoReparacao as $linha): ?>
                                    <tr>
                                        <td>
                                            <?php if($linha->item != null): ?>
                                                <?= Html::a($linha->item->nome, ['item/view', 'id' => $linha->item->id]) ?>
                                            <?php else: ?>
                                                <?= Html::a($linha->grupo->nome, ['grupoitens/view', 'id' => $linha->grupo->id]) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($linha->item != null): ?>
                                                <?= $linha->item->getDataAlocacaoBaseadoEmData($model->dataPedido) ?>
                                            <?php else: ?>
                                                <?= $linha->grupo->getDataAlocacaoBaseadoEmData($model->dataPedido) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">Sem dados a mostrar. Talvez <?= Html::a('continuar', ['pedidoreparacao/linhas', 'id' => $model->id]) ?>?</td>
                                </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header font-weight-bold">
            Despesas
            <?php if($model->status == PedidoReparacao::STATUS_EM_REVISAO): ?>
                <?= Html::a("Adicionar despesa", ['linha-despesas-reparacao/create', 'idReparacao' => $model->id], ['class' => 'btn btn-primary float-right']) ?>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <td>Descrição</td>
                        <td style="width: 1%; white-space: nowrap;">Quantidade</td>
                        <td style="width: 1%; white-space: nowrap;">Gasto/Un.</td>
                        <td style="width: 1%; white-space: nowrap;">Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($model->linhasDespesasReparacao) > 0): ?>
                        <?php foreach ($model->linhasDespesasReparacao as $despesa): ?>
                            <tr>
                                <td><?= $despesa->descricao ?></td>
                                <td><?= $despesa->quantidade ?></td>
                                <td><?= $despesa->preco . "€" ?></td>
                                <td><?= ($despesa->quantidade * $despesa->preco) . "€" ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2"></td>
                            <td><b>Total:</b></td>
                            <td><?= $model->calcularTotalDespesas() ?>€</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Sem despesas associadas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>