<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */

$this->title = 'Update Grupoitens: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grupoitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grupoitens-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
