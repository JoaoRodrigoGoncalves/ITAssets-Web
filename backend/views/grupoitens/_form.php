<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\GruposItens_Item $itensGrupo */
?>

<div class="grupoitens-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <div class="card">
        <?= $form->field(new \common\models\GruposItens_Item(),'item_id',['options' => ['class' => 'list-group-item']])->checkboxList(ArrayHelper::map($itens,'id','nome'), ['separator' => '<br>'])->label('Item')?>
    </div>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
