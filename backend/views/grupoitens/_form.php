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

    <?php if(isset($model_item)){?>
    <div class="card">
        <?= $form->field($model_item,'item_id',['options' => ['class' => 'list-group-item']])->checkboxList(\yii\helpers\ArrayHelper::map($itens,'id','nome'), ['separator' => '<br>'])->label('Item')?>
    </div>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
