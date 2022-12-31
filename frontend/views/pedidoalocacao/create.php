<?php

use common\models\Grupoitens;
use common\models\Item;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */
/** @var \common\models\CustomTableRow $customTableData */
/** @var string $selectedItem */

$this->title = 'Novo Pedido de Alocação';
?>
<div class="m-5">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="card">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h5>Objeto Selecionado</h5>
                    <?php
                    $objectSelectorConfig = [
                        'Callback' => '/pedidoalocacao/create',
                        'SearchFor' => [
                            [
                                'model' => Item::class,
                                'functionRules' => [
                                    [
                                        'function' => '!isInActiveItemsGroup',
                                    ],
                                    [
                                        'function' => '!isInActivePedidoAlocacao',
                                    ],
                                ]
                            ],
                            [
                                'model' => Grupoitens::class,
                                'functionRules' => [
                                    [
                                        'function' => '!isInActivePedidoAlocacao',
                                    ],
                                ]
                            ]
                        ],
                        'Multiselect' => false,
                    ];

                    ?>

                    <?= Html::a("Selecionar Objeto", ['/object-select/index'], ['class' => 'btn btn-primary mb-2' ,'data' => [
                        'method' => 'POST',
                        'params' => ['config' => json_encode($objectSelectorConfig)]
                    ]]) ?>
                    <br>
                    <?= $model->getErrors('item_id')[0] ?? "" ?>
                    <?= $model->getErrors('grupoItem_id')[0] ?? "" ?>
                </li>
                <li class="list-group-item">
                    <?php $form = ActiveForm::begin(); ?>
                    <input type="hidden" name="selectedItem" value="<?= $selectedItem ?>">

                    <label class="control-label">Objeto</label>

                    <table class="table table-bordered">
                        <?php if($customTableData != null): ?>
                            <tr>
                                <td><?= $customTableData->nome ?></td>
                                <td><?= $customTableData->serial ?></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">Nenhum objeto selecionado</td>
                            </tr>
                        <?php endif; ?>
                    </table>

                    <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>
                </li>
            </ul>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success float-right']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>