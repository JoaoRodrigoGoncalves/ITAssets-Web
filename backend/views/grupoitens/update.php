<?php

use common\models\Item;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var yii\widgets\ActiveForm $form */
/** @var string $itensSelecionados_string */
/** @var array $itensSelecionados */

$this->title = 'Edição de Grupo de Itens "' . $model->nome . '"';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Itens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Grupo "' . $model->nome . '"', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';

?>

<div class="container grupoitens-form card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>