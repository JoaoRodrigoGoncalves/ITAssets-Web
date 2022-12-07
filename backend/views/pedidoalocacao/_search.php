<?php

use common\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedido-alocacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'status')->dropDownList(['10' => 'Aberto', '9' => 'Aprovado', '8' => 'Negado', '0' => 'Cancelado'], ['prompt' => 'Todos']) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'dataPedido')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'requerente_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(User::findAll(['status' => 10]), 'id', 'username'),
                'language' => 'pt',
                'options' => ['placeholder' => 'Selecione um Utilizador ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col">
            <?php
                $aprovadoresValidos = Yii::$app->authManager->getUserIdsByRole('administrador');
                $aprovadoresValidos += Yii::$app->authManager->getUserIdsByRole('operadorLogistica');

                echo $form->field($model, 'aprovador_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(User::find()->where(['id' => $aprovadoresValidos, 'status' => 10])->all(), 'id', 'username'),
                    'language' => 'pt',
                    'options' => ['placeholder' => 'Selecione um Utilizador ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
    </div>

    <div class="form-group float-right">
        <?= Html::submitButton('Procurar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['pedidoalocacao/index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
