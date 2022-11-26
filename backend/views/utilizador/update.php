<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Utilizador $model */

$this->title = 'Atualizar ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="container">
    <h2>Atualizador de Utilizadores</h2>
    <br>
    <div class="card">
        <div class="card-body">

            <?= $this->render('_formUpdate', [
                'model' => $model,
                'roles' => $roles,
            ]) ?>


        </div>
    </div>
</div>
