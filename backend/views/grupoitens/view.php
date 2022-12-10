<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Grupoitens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="grupoitens-view">
    <div class="container mt-3">
        <div class="card">
            <div class="card-header bg-info">
                <h2>Detalhes do Grupo Itens Nº<?=$model->id?></h2>
            </div>
            <div class="card-body">
                <div>
                    <h4>Nome do Grupo: <?= $model->nome ?></h4>
                    Notas:
                    <br>
                    <div style="margin-left:10px"><?= $model->notas ?></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <a href="<?=Url::to(['grupoitens/update/'.$model->id]) ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>

                    <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Tens certeza que queres eliminar este grupo?',
                            'method' => 'post',
                        ],

                    ]) ?>
                </div>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <h2>Itens associados</h2>
                <br>
                <div>
                    <table class="table">
                        <thead class="thead-info">
                        <tr>
                            <td>N</td>
                            <td>Nome do Item</td>
                            <td>Numero de Serie</td>
                            <td scope="col">Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($itens as $item){ ?>
                            <tr>

                                <td>1</td>
                                <td><?= $item->nome; ?></td>
                                <td><?= $item->serialNumber; ?></td>
                                <td>
                                    <a href="<?=Url::to(['item/view/', 'id' => $item->id]) ?>" class="btn btn-primary"><i class="fas fa-info-circle"></i></a>
                                </td>

                            </tr>
                        <?php }?>
                        </tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>






</div>
