<?php
use common\models\Empresa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Item $item */

?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Detalhes de Itens</h2>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $item,
                'attributes' => [
                    'nome',
                    'serialNumber',
                    [
                        'label' => 'Categoria',
                        'value' => $item->categoria->nome ?? "N/A",
                    ],
                    'notas',
                ],
            ]) ?>
        </div>
        <div class="card-footer text-right">
            <a href="<?= Url::to(['item/update', 'id' => $item->id]) ?>" class="btn btn-primary" >Editar</a>
            <a href="<?= Url::to(['item/delete', 'id' => $item->id]) ?>" class="btn btn-danger">Eliminar</a>
        </div>
    </div>
</div>
