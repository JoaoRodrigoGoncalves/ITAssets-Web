<?php

use common\models\PedidoAlocacao;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var array $historyProvider*/

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Itens', 'url' => ['index']];
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
                    <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['grupoitens/update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']) ?>

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
                            <td>Nome do Item</td>
                            <td>Número de Série</td>
                            <td style="width: 1%; white-space: nowrap">Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->items as $item){ ?>
                            <tr>
                                <td><?= $item->nome; ?></td>
                                <td><?= $item->serialNumber ?? "<i>Não Aplicável</i>"; ?></td>
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

        <div class="card">
            <div class="card-header">
                <h4>Histórico</h4>
            </div>
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $historyProvider,
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'label' => 'Data',
                            'value' => 'data'
                        ],
                        [
                            'label' => 'Evento',
                            'format' => 'html',
                            'value' => 'message'
                        ],
                    ],
                    'pager' => [
                        'activePageCssClass' => 'page-item active',
                        'maxButtonCount' => 8,

                        // Css for each options. Links
                        'linkOptions' => ['class' => 'page-link'],
                        'disabledPageCssClass' => 'page-link disabled',

                        // Customzing CSS class for navigating link
                        'prevPageCssClass' => 'page-item',
                        'nextPageCssClass' => 'page-item',
                        'firstPageCssClass' => 'page-item',
                        'lastPageCssClass' => 'page-item'
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
