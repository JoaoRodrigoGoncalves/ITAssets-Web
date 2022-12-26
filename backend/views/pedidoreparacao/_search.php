<?php

use common\models\PedidoReparacao;
use common\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pedido-reparacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'id') ?>
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
        <div class="col">
            <?= $form->field($model, 'status')->dropDownList([
                    PedidoReparacao::STATUS_EM_PREPARACAO => 'Em Preparação',
                    PedidoReparacao::STATUS_ABERTO => 'Aberto',
                    PedidoReparacao::STATUS_EM_REVISAO => 'Em Revisão',
                    PedidoReparacao::STATUS_CONCLUIDO => 'Concluído',
                    PedidoReparacao::STATUS_CANCELADO => 'Cancelado'
            ], ['prompt' => 'Todos']) ?>
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
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'responsavel_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(User::findAll(['status' => User::STATUS_ACTIVE]), 'id', 'username'),
                'language' => 'pt',
                'options' => ['placeholder' => 'Selecione um Utilizador ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group float-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Limpar', ['pedidoreparacao/index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
