<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */


$this->params['breadcrumbs'][] = ['label' => 'Item', 'url' => ['index']];
?>
<div class="container">
    <h2>Registo de Itens</h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
