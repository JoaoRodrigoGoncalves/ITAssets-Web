<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \backend\models\Utilizador $model */
/** @var yii\rbac\Role[] $roles */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'password')->passwordInput(['required' => true]) ?>

    <?= $form->field($model,'repeat_password')->passwordInput(['required' => true]) ?>

    <?=  $form->field($model,'role')->dropDownList($roles)?>


    <?= Html::submitButton('Registar', ['class' => 'btn btn-success btn-lg btn-block']) ?>


    <?php ActiveForm::end(); ?>
</div>
