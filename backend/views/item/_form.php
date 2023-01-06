<?php

use common\models\Categoria;
use common\models\Site;
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

    <?= $form->field($model, 'categoria_id')->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'nome'), ['prompt' => '- Nenhum -']); ?>

    <?= $form->field($model, 'site_id')->dropDownList(ArrayHelper::map(Site::find()->all(), 'id', 'nome'), ['prompt' => '- Nenhum -']); ?>

    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block','name'=>'save']) ?>


    <?php ActiveForm::end(); ?>
</div>
