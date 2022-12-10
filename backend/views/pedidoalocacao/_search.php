<?php

use common\models\PedidoAlocacao;
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
            <?= $form->field($model, 'status')->dropDownList([
                    PedidoAlocacao::STATUS_ABERTO => 'Aberto',
                    PedidoAlocacao::STATUS_APROVADO => 'Aprovado',
                    PedidoAlocacao::STATUS_NEGADO => 'Negado',
                    PedidoAlocacao::STATUS_DEVOLVIDO => 'Devolvido',
                    PedidoAlocacao::STATUS_CANCELADO => 'Cancelado'
                ], ['prompt' => 'Todos']) ?>
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
                'data' => ArrayHelper::map(User::findAll(['status' => User::STATUS_ACTIVE]), 'id', 'username'),
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
                    'data' => ArrayHelper::map(User::find()->where(['id' => $aprovadoresValidos, 'status' => User::STATUS_ACTIVE])->all(), 'id', 'username'),
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
