<?php

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */
/** @var CustomTableRow[] $customTableData */
/** @var string $selectedItem*/

$this->title = 'Pedido de Alocação de Itens';
$this->params['breadcrumbs'][] = ['label' => 'Pedidos Alocação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= $this->title ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
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

            <?php $form = ActiveForm::begin(); ?>
            <input type="hidden" name="selectedItem" value="<?= $selectedItem ?>">

            <?php
            $array_users = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->orderBy('username')->all(), 'id', function($userModel)
            {
                return $userModel['username'] . " (" . $userModel['email'] . ")";
            });
            ?>

            <?= $form->field($model, 'requerente_id')->dropDownList($array_users, ['prompt' => '- Selecione um utilizador -']) ?>

            <label class="control-label">Item</label>
            <table class="table table-bordered">
                <?php if($customTableData != null): ?>
                    <tr>
                        <td><?= $customTableData->nome ?></td>
                        <td><?= $customTableData->info_adicional ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2">Nenhum objeto selecionado</td>
                    </tr>
                <?php endif; ?>
            </table>

            <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Alocar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
