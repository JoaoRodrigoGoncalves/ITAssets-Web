<?php

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
        <?= Html::a('Devolver ao inventário', ['idk', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php if($model->status == 10): ?>
            <?= Html::a('Aprovar', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Negar', ['negate', 'id' => $model->id], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
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
