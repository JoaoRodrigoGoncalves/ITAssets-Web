<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedido-reparacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'dataPedido') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'status') ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'requerente_id') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'responsavel_id') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
