<?php

use backend\models\Utilizador;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Utilizador $model */
/** @var yii\rbac\Role[] $roles */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?=  $form->field($model,'role')->dropDownList($roles)?>

    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>

    <?php ActiveForm::end(); ?>
</div>
