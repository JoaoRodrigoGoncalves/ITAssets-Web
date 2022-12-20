<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */
/** @var \yii\data\ArrayDataProvider $objectosSelecionados */
/** @var string $objectosSelecionados_string */

$this->title = 'Criar Novo Pedido de Reparação';
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-reparacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'objectosSelecionados' => $objectosSelecionados,
        'objectosSelecionados_string' => $objectosSelecionados_string,
    ]) ?>

</div>
