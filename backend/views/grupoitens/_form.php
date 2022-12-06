<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="grupoitens-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <div class="card">
        <?= $form->field($model_item,'item_id',['options' => ['class' => 'list-group-item']])->checkboxList(\yii\helpers\ArrayHelper::map($itens,'id','nome'), ['separator' => '<br>'])->label('Item')?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
