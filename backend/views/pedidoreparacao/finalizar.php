<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */

$this->title = 'Finalizar Pedido Reparação Nº' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedidos de Reparação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Pedido de Reparação Nº' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Finalizar Pedido';
?>
<div class="pedido-reparacao-update container mt-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['action' => '/pedidoreparacao/finalizar/' . $model->id]); ?>

                <?= $form->field($model, 'respostaObs')->textarea(['rows' => 10]) ?>

                <?= Html::submitButton('Finalizar Pedido de Reparação', ['class' => 'btn btn-success float-right']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
