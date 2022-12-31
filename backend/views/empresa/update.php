<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Empresa $model */

$this->title = 'Edição Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', ['model' => $model,
            ]) ?>
        </div>
    </div>
</div>
