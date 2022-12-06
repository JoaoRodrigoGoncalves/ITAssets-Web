<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */

$this->title = 'Create Grupoitens';
$this->params['breadcrumbs'][] = ['label' => 'Grupoitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupoitens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=

    $this->render('_form', [
        'model' => $model,
        'itens'=> $itens,
        'model_item'=>$model_item,
    ]) ?>

</div>
