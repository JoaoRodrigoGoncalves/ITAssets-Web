<?php

use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="float-right">
                <?= Html::a('<i class="fas fa-plus"></i> Registar', ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="card-body">
            <?=GridView::widget([
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
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', ['categoria/update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']);
                            },
                            'delete' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['categoria/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data'=> [
                                        'confirm' => 'Tem a certeza que quer eliminar esta categoria?',
                                        'method'=> 'POST'
                                    ]
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
