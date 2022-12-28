<?php

use common\models\User;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */
/** @var yii\widgets\ActiveForm $form */
/** @var ArrayDataProvider $objectosSelecionados */
/** @var string $objectosSelecionados_string */

$this->title = 'Criar Novo Pedido de Reparação';
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>
<div class="card m-5">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?php
        $array_users = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->orderBy('username')->all(), 'id', function($userModel)
        {
            return $userModel['username'] . " (" . $userModel['email'] . ")";
        });
        ?>

        <?= $form->field($model, 'requerente_id')->dropDownList($array_users, ['prompt' => '- Selecione um utilizador -']) ?>

        <?= $form->field($model, 'descricaoProblema')->textarea(['rows' => 6]) ?>
    </div>

    <div class="card-footer">
        <div class="form-group">
            <?= Html::submitButton('Continuar&nbsp;&nbsp;<i class="fa fa-arrow-alt-circle-right"></i>', ['class' => 'btn btn-success float-right']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
