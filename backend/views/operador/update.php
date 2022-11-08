<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Atualizar dados: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Operador', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operador-update">

        <?= dd($model);?>

<!--    --><?//= $this->render('_form', [
//        'model' => $model,
//        'roles' => $roles,
//    ]) ?>

</div>
