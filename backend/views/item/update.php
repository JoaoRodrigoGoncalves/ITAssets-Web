<?php

use common\models\Categoria;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Item $item */

$this->title = 'Edição de Item';
$this->params['breadcrumbs'][] = ['label' => 'Item', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';

?>

<div class="container mt-2">
    <h2>Edição de Itens</h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
            ])
            ?>
                <?= $form->field($item, 'nome')->textInput()->label('Name') ?>
                <?= $form->field($item, 'serialNumber')->textInput()->label('Número de Série')?>
                <?= $form->field($item, 'notas')->textArea()->label('Observação')?>
                <?= $form->field($item, 'categoria_id')->dropDownList(ArrayHelper::map(Categoria::find()->all(), 'id', 'nome'));
                ?>

                <div class="form-group float-right">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
