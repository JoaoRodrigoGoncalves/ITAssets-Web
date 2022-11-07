<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Criar Operador';
$this->params['breadcrumbs'][] = ['label' => 'Operador', 'url' => ['index']];

?>
<div>


    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>
</div>
