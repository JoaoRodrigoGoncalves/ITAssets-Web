<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */

$this->title = 'Novo Pedido de Alocação';
?>
<div class="m-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'customTableData' => $customTableData,
    ]) ?>

</div>
