<?php

use common\models\PedidoReparacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos de Reparação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-2">
                    <?= Html::a('<i class="fas fa-plus"></i> Reparação', ['create'], ['class' => 'btn btn-success w-100 mb-2']) ?>
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
                    'id',
                    'dataPedido',
                    [
                        'label' => 'Relatador',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return Html::a($data->requerente->username, ['utilizador/view', 'id' => $data->requerente->id]);
                        }
                    ],
                    [
                        'label' => 'Responsável',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->responsavel != null)
                            {
                                return Html::a($data->responsavel->username, ['utilizador/view', 'id' => $data->responsavel->id]);
                            }
                            else
                            {
                                return "<i>Não aplicável</i>";
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
                                return Html::a('<i class="fas fa-eye"></i>', ['pedidoreparacao/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                return match ($model->status) {
                                    PedidoReparacao::STATUS_ABERTO => Html::a('<i class="fas fa-reply"></i>', ['pedidoreparacao/selfassign', 'id' => $model->id], ['class' => 'btn btn-secondary']),
                                    PedidoReparacao::STATUS_EM_REVISAO => Html::a('<i class="fas fa-reply"></i>', ['pedidoreparacao/finalizar', 'id' => $model->id], ['class' => 'btn btn-secondary']),
                                    default => null,
                                };
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
