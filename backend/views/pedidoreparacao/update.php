<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */

$this->title = 'Update Pedido Reparacao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pedido-reparacao-update">

    <h1><?= Html::encode($this->title) ?></h1>



</div>
