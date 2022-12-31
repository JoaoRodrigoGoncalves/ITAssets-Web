<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */

$this->title = 'Edição do Grupo Itens: Nº' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grupoitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
