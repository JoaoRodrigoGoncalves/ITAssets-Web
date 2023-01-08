<?php

/** @var \common\models\PedidoReparacao $model*/
/** @var \yii\data\ArrayDataProvider $objectosSelecionados */
/** @var string $objectosSelecionados_string */

use common\models\Grupoitens;
use common\models\Item;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Seleção de Objetos";
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Pedido Nº' . $model->id];
$this->params['breadcrumbs'][] = 'Seleção de Objetos';
?>

<div class="card m-3">
    <div class="card-header">
        <?php
            $objectSelectorConfig = [
                'Callback' => '/pedidoreparacao/linhas/' . $model->id,
                'SearchFor' => [
                    [
                        'model' => Item::class,
                        'functionRules' => [
                            [
                                'function' => 'isAlocatedToUser',
                                'args' => [$model->requerente_id]
                            ],
                            [
                                'function' => '!isInActiveItemsGroup',
                            ],
                            [
                                'function' => '!isInActivePedidoReparacao',
                            ],
                        ]
                    ],
                    [
                        'model' => Grupoitens::class,
                        'functionRules' => [
                            [
                                'function' => 'isAlocatedToUser',
                                'args' => [$model->requerente_id]
                            ],
                            [
                                'function' => '!isInActivePedidoReparacao',
                            ],
                        ]
                    ]
                ],
                'Multiselect' => true,
            ];
        ?>
        <?= Html::a('<i class="fa-solid fa-hand-pointer"></i> Selecionar Objetos', ['/object-select/index'], ['class' => 'btn btn-primary mb-2' ,'data' => [
            'method' => 'POST',
            'params' => ['config' => json_encode($objectSelectorConfig)]
        ]]) ?>
    </div>
    <div class="card-body">
        <?php if($objectosSelecionados != null): ?>
            <h4>Itens Selecionados:</h4>
            <?= GridView::widget([
                'dataProvider' => $objectosSelecionados,
                'summary' => '',
                'columns' => [
                    [
                        'label' => 'Nome',
                        'value' => 'nome'
                    ],
                    [
                        'label' => 'Informação Adicional',
                        'value' => 'info_adicional'
                    ],
                ]
            ]);
            ?>
        <?php else: ?>
            <p>Não existem objetos selecionados</p>
        <?php endif; ?>
    </div>
    <div class="card-footer">
        <?php ActiveForm::begin(['action' => '/pedidoreparacao/linhas/' . $model->id]) ?>
            <input type="hidden" name="selectedObjects" value="<?= $objectosSelecionados_string ?>">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success float-right']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
