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
<div class="container flex-grow-1 container-p-y mt-3">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Local "<?= $this->title ?>"</h2>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nome',
                    [
                        'label' => 'Morada',
                        'format' => 'html',
                        'value' => $model->rua == null ? "<i>Não Aplicável</i>" : $model->rua . ", " . $model->codPostal . " " . $model->localidade
                    ],
                    [
                        'label' => 'Coordenadas',
                        'format' => 'html',
                        'value' => $model->coordenadas ?? "<i>Não Aplicável</i>",
                    ],
                    [
                        'label' => 'Notas',
                        'format' => 'html',
                        'value' => $model->notas ?? "<i>Não Aplicável</i>",
                    ],
                ],
            ]) ?>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <?= Html::a('<i class="fas fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']) ?>
                <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h2>Itens Associados</h2>

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
                            <td><?= $item->categoria->nome ?? "<i>Não Aplicável</i>" ?></td>
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
