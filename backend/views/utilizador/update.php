<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Utilizador $model */
/** @var \yii\rbac\Role[] $roles */

$this->title = 'Edição do Utilizador ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="container">
    <h2><?=$this->title?></h2>
    <br>
    <div class="card">
        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
                'roles' => $roles,
            ]) ?>


        </div>
    </div>
</div>
