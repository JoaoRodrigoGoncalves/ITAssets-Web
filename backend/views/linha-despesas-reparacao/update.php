<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\LinhaDespesasReparacao $model */

$this->title = 'Update Linha Despesas Reparacao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linha Despesas Reparacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linha-despesas-reparacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
