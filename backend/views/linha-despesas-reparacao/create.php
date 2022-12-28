<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaDespesasReparacao $model */

$this->title = 'Adicionar nova despesa';
$this->params['breadcrumbs'][] = ['label' => 'Pedido de Reparação Nº' . $model->pedidoReparacao->id, 'url' => ['pedidoreparacao/view', 'id' => $model->pedidoReparacao->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="linha-despesas-reparacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
