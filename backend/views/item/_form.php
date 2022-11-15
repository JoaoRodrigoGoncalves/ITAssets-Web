<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var common\models\Item $model */

?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serialNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'notas')->textInput(['maxlength' => true]) ?>


    <?= Html::submitButton('Registar', ['class' => 'btn btn-success btn-lg btn-block']) ?>


    <?php ActiveForm::end(); ?>
</div>
