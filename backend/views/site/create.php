<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Site $model */

$this->title = 'Registar local';
$this->params['breadcrumbs'][] = ['label' => 'Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h2><?= $this->title ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
