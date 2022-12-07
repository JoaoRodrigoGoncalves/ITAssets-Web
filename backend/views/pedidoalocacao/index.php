<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedidos Alocação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-2">
                    <?= Html::a('Alocar Item', ['create'], ['class' => 'btn btn-success w-100 mb-2']) ?>
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
                'columns' => [
                    'id',
                    'dataPedido',
                    [
                        'label' => 'Requerente',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->requerente != null)
                            {
                                return Html::a($data->requerente->username, ['utilizador/view', 'id' => $data->requerente->id]);
                            }
                            else
                            {
                                return "N/A";
                            }
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
                                return "N/A";
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
                                if($model->status == 10)
                                {
                                    return Html::a('<i class="fas fa-thumbs-up"></i>', ['pedidoalocacao/update', 'id' => $model->id], ['class' => 'btn btn-secondary']);
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
