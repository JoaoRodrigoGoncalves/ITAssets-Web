<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="operador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <h6><b>Password</b></h6>
    <?= $form->field($model,'password')->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'required' => true]) ?>

    <?=  $form->field($model,'role')->dropDownList($roles)?>

    <?= Html::submitButton('Registar', ['class' => 'btn btn-success btn-lg btn-block']) ?>

    <?php ActiveForm::end(); ?>

</div>
