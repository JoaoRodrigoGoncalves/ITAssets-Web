<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $item */
$this->title = 'Registo de Itens';
$this->params['breadcrumbs'][] = ['label' => 'Item', 'url' => ['index']];
?>
<div class="container mt-3">
    <h2><?=$this->title?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $item,
            ]) ?>
        </div>
    </div>
</div>
