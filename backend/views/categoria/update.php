<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = 'Update Categoria: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container mt-2">
    <h2>Edição da Categoria: <?=$model->nome?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
            ])
            ?>
            <?= $form->field($model, 'nome')->textInput()->label('Name') ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
