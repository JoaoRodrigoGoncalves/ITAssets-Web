<?php

use common\models\CustomTableRow;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */
/** @var yii\widgets\ActiveForm $form */
/** @var CustomTableRow[] $customTableData*/
?>

<div class="pedido-alocacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <label class="control-label">Item</label>
    <?= $model->getErrors('item_id')[0] ?? "" ?>
    <?= $model->getErrors('grupoItem_id')[0] ?? "" ?>
    <table class="table">
        <thead>
        <tr>
            <th style="width: 1%;"></th>
            <th>Nome</th>
            <th>Serial</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($customTableData as $row): ?>
            <tr>
                <td><input type="radio" name="item" value="<?= $row->id ?>" required></td>
                <td><?= $row->nome ?></td>
                <td><?= $row->serial ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
