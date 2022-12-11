<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var \common\models\Item[] $itens */

$this->title = 'Registo Grupos de Itens';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Itens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'itens'=> $itens,
            ]) ?>
        </div>
    </div>
</div>
