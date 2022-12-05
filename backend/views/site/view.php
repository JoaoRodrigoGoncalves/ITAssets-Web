<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Site $model */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <h2><?= $this->title ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nome',
                    [
                        'label' => 'Morada',
                        'value' => $model->rua == null ? "N/A" : $model->rua . ", " . $model->codPostal . " " . $model->localidade
                    ],
                    'coordenadas',
                    'notas',
                ],
            ]) ?>

            <br><h4>Itens</h4>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th style="width: 1%;"></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($model->getItems()->count() > 0): ?>
                    <?php foreach ($model->items as $item): ?>
                        <tr>
                            <td><?= $item->nome ?></td>
                            <td><?= $item->categoria->nome ?></td>
                            <td>
                                <?= Html::a('<i class="fas fa-search"></i>', ['item/view', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="3">Sem dados a mostrar</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
