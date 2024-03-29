<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos de Alocação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-2">
                    <?= Html::a('<i class="fas fa-plus"></i> Alocar', ['create'], ['class' => 'btn btn-success w-100 mb-2']) ?>
                    <a class="btn btn-primary w-100" data-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="filterCollapse">
                        Filtros
                    </a>
                </div>
                <div class="col-10">
                    <div class="collapse" id="filterCollapse">
                        <?= $this->render("_search", ['model' => $searchModel]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{items}\n{summary}\n{pager}",
                'emptyText' => "Sem registos a mostrar.",
                'summary' => "A apresentar de <b>{begin}</b> a <b>{end}</b> de <b>{totalCount}</b> registos.",
                'columns' => [
                    [
                        'label' => 'ID Pedido',
                        'value' => 'id'
                    ],
                    [
                        'label' => 'Data Pedido',
                        'value' => 'dataPedido'
                    ],
                    [
                        'label' => 'Item',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->item_id != null)
                            {
                                return Html::a($data->item->nome, ['item/view', 'id' => $data->item->id]);
                            }
                            else
                            {
                                return Html::a($data->grupoItem->nome, ['grupoitens/view', 'id' => $data->grupoItem->id]);
                            }
                        }
                    ],
                    [
                        'label' => 'Requerente',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return Html::a($data->requerente->username, ['utilizador/view', 'id' => $data->requerente->id]);
                        }
                    ],
                    [
                        'label' => 'Aprovador',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->aprovador != null)
                            {
                                return Html::a($data->aprovador->username, ['utilizador/view', 'id' => $data->aprovador->id]);
                            }
                            else
                            {
                                return "<i>Não Aplicável</i>";
                            }
                        }
                    ],
                    [
                        'label' => 'Estado',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return $data->getPrettyStatus();
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-eye"></i>', ['pedidoalocacao/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                if($model->status == PedidoAlocacao::STATUS_ABERTO)
                                {
                                    return Html::a('<i class="fas fa-reply"></i>', ['pedidoalocacao/update', 'id' => $model->id], ['class' => 'btn btn-secondary']);
                                }
                                return null;
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
