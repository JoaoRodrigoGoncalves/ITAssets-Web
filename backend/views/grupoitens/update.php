<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */

$this->title = 'Edição de Grupo Itens Nº' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grupoitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
