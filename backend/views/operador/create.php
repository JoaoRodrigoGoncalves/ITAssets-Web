<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->params['breadcrumbs'][] = ['label' => 'Operador', 'url' => ['index']];

?>
<div class="container">
    <h2>Registo de Utilizadores</h2>
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
