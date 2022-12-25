<?php

use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhaDespesasReparacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card m-5">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-sm">
                <?= $form->field($model, 'quantidade')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'digits' => 3,
                        'allowMinus' => false,
                    ],
                    'displayOptions' => [
                        'placeholder' => 'Indique um valor válido',
                    ]
                ]) ?>
            </div>
            <div class="col-sm">
                <?= $form->field($model, 'preco')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => ' €',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'allowMinus' => false,
                    ],
                    'displayOptions' => [
                            'placeholder' => 'Indique um valor válido',
                    ]
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
