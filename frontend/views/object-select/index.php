<?php
/** @var yii\web\View $this */
/** @var \yii\data\ArrayDataProvider $tableData */
/** @var boolean $multiselect */
/** @var string $callback */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Seleção de objeto";
?>
<h1><?= $this->title ?></h1>
<div class="card m-5">
    <div class="card-header">
        <!-- TODO: Pesquisa -->
        <p>Pesquisa</p>
    </div>
    <?= Html::beginForm($callback) ?>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $tableData,
                'layout' => "{items}\n{summary}",
                'columns' => [
                    [
                        'class' => ($multiselect ? 'yii\grid\CheckboxColumn' : 'yii\grid\RadioButtonColumn'),
                        'headerOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'checkboxOptions' => function($model) {
                                return ['value' => $model->id, 'class' => 'checkbox-row', 'id' => 'checkbox'];
                        }
                    ],
                    [
                        'label' => 'Nome',
                        'value' => 'nome'
                    ],
                    [
                        'label' => 'Serial',
                        'format' => 'html',
                        'value' => 'serial'
                    ],
                ]
            ]);
            ?>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Guardar Seleção', ['class' => 'float-right btn btn-success']) ?>
        </div>
    <?= Html::endForm() ?>
</div>
