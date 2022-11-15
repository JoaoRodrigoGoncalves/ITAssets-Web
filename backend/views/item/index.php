<?php

use common\models\Empresa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<div class="container mt-5">
    <h2>Gestão de Items</h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-box"></i> Registar', ['create'], ['class' => 'btn btn-primary float-right']) ?>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">SerialNumber</th>
                    <th scope="col">Notas</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($itens as $item){ ?>
                    <tr>
                        <td><?=$item->nome?></td>
                        <td><?=$item->serialNumber?></td>
                        <td><?=$item->notas?></td>
                        <td>
                            <a href="" class="btn btn-success"><i class="fas fa-user-edit"></i></a>
                            <a href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
