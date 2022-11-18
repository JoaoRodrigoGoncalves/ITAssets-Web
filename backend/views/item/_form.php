<?php

use common\models\Categoria;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var common\models\Item $model */

?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serialNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'notas')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'nome')); ?>

    <?= Html::submitButton('Registar', ['class' => 'btn btn-success btn-lg btn-block']) ?>


    <?php ActiveForm::end(); ?>
</div>
