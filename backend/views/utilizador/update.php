<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Atualizar ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="operador-update">

        <?= dd($model);?>

<!--    --><?//= $this->render('_form', [
//        'model' => $model,
//        'roles' => $roles,
//    ]) ?>

</div>
