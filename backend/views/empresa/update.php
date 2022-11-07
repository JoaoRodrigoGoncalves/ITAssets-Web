<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Empresa $model */

$this->title = 'Atualizar dados: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="empresa-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
