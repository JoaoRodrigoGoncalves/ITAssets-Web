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
    <h2>Edição do Item: <?=$item->nome?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $item,
            ]) ?>
        </div>
    </div>
</div>
