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
    <h2>Edição de Categorias</h2>
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

            <div class="form-group float-right">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
