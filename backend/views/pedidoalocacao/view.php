<?php

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pedido Alocação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pedido-alocacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($model->status == PedidoAlocacao::STATUS_APROVADO): ?>
            <?= Html::a('Devolver ao inventário', ['return', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>

        <?php if($model->status == PedidoAlocacao::STATUS_ABERTO): ?>
            <?= Html::a('<i class="fas fa-thumbs-up"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
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
