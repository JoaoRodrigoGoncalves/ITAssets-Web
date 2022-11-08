<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Empresa $model */

$this->title = 'Edição Empresa ';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresa-update">



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

</div>
