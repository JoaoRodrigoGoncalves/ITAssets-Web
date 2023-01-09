<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\PedidoReparacaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedido-reparacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<!--    TODO: Projeto final-->

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'dataPedido') ?>

    <?= $form->field($model, 'dataInicio') ?>

    <?= $form->field($model, 'dataFim') ?>

    <?= $form->field($model, 'descricaoProblema') ?>

    <?php // echo $form->field($model, 'requerente_id') ?>

    <?php // echo $form->field($model, 'responsavel_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'respostaObs') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
