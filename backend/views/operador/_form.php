<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="operador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'password')->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'required' => true]) ?>

    <?=  $form->field($model,'role')->dropDownList($roles)?>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
