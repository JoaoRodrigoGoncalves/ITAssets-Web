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
                <?= Html::a('<i class="fas fa-stream"></i> Registar', ['create'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="card-body">
            <?=GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{items}\n{summary}\n{pager}",
                'columns' => [
                    'nome',
                    [
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $column) {
                            $data = Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['categoria/update', 'id' => $model->id]),
                                [
                                    'id'=>'grid-custom-button',
                                    'data-pjax'=>true,
                                    'action'=>Url::to(['categoria/update', 'id' => $model->id]),
                                    'class'=>'button btn btn-warning text-white mr-2',
                                ]
                            );

                            $data .= Html::a('<i class="fas fa-trash-alt"></i>', Url::to(['categoria/delete', 'id' => $model->id]),
                                [
                                    'id'=>'grid-custom-button',
                                    'data-pjax'=>true,
                                    'action'=>Url::to(['categoria/delete', 'id' => $model->id]),
                                    'class'=>'button btn btn-danger',

                                ]

                            );

                            return $data;
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
