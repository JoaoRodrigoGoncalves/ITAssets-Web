<?php

use common\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-box"></i> Create Item', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{items}\n{summary}\n{pager}",
                'emptyText' => "Sem dados a mostrar.",
                'summary' => "A apresentar de <b>{begin}</b> a <b>{end}</b> de <b>{totalCount}</b> registos.",
                'columns' => [
                    [
                        'label' => 'Nome',
                        'value' => 'nome'
                    ],
                    [
                        'label' => 'Nº de Série',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return $data->serialNumber ?? "<i>Não Aplicável</i>";
                        }
                    ],
                    [
                        'label' => 'Categoria',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return $data->categoria->nome ?? "<i>Não Aplicável</i>";
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-eye"></i>', ['item/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', ['item/update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']);
                            },
                            'delete' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['item/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data'=>['method'=>'POST']]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
