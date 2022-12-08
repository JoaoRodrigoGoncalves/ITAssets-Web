<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedido Alocacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pedido-alocacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($model->status == PedidoAlocacao::STATUS_ABERTO): ?>
            <?= Html::a('Delete', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'item_id',
            'grupoItem_id',
            'dataInicio',
            'dataFim',
            'obs:ntext',
            'obsResposta:ntext',
            'requerente_id',
            'aprovador_id',
        ],
    ]) ?>

</div>
