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
    <?= Html::beginForm($callback) ?>
        <div class="card-body">
            <?php

                if($multiselect)
                {
                    // Tabela com Checkbox
                    echo GridView::widget([
                        'dataProvider' => $tableData,
                        'layout' => "{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
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
                                'label' => 'Informação Adicional',
                                'format' => 'html',
                                'value' => 'info_adicional'
                            ],
                        ]
                    ]);
                }
                else
                {
                    // Tabela com radio button
                    echo GridView::widget([
                        'dataProvider' => $tableData,
                        'layout' => "{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\RadioButtonColumn',
                                'headerOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                                'radioOptions' => function($model)
                                {
                                    return ['value' => $model->id, 'id' => 'radiobtn', 'checked' => false, 'required' => true];
                                }
                            ],
                            [
                                'label' => 'Nome',
                                'value' => 'nome'
                            ],
                            [
                                'label' => 'Informação Adicional',
                                'format' => 'html',
                                'value' => 'info_adicional'
                            ],
                        ]
                    ]);
                }

            ?>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Guardar Seleção', ['class' => 'float-right btn btn-success']) ?>
        </div>
    <?= Html::endForm() ?>
</div>
