<?php

use common\models\Grupoitens;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Grupos de Itens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-plus"></i> Registar', ['create'], ['class' => 'btn btn-primary float-right']) ?>
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
                        'label' => 'Notas',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return $data->notas != null ? substr($data->notas, 0, 20) . "..." : "<i>Não Aplicável</i>";
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-eye"></i>', ['grupoitens/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', ['grupoitens/update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']);
                            },
                            'delete' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['grupoitens/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data'=> [
                                        'confirm' => 'Tem a certeza que quer eliminar este grupo de itens?',
                                        'method'=> 'POST'
                                    ]
                                ]);
                            },
                        ],
                    ],
                ],
            ]);?>
        </div>
    </div>



</div>
