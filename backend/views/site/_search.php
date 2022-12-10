<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SiteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

    <div class="input-group">
        <?= $form->field($model, 'nome', ['options' => ['class' => 'form-group']])->textInput(['placeholder' => 'Procurar', 'class' => 'form-control'])->label(false) ?>
        <div class="input-group-append">
            <!-- TODO: remover estilo fixo -->
            <?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-outline-secondary', 'style' => 'height: 38px']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
