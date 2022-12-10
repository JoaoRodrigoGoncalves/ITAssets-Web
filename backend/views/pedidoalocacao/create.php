<?php

use common\models\CustomTableRow;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */
/** @var CustomTableRow[] $customTableData */

$this->title = 'Pedido de Alocação de Itens';
$this->params['breadcrumbs'][] = ['label' => 'Pedidos Alocação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= $this->title ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'customTableData' => $customTableData,
            ]) ?>
        </div>
    </div>
</div>
