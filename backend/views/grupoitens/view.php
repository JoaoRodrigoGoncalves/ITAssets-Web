<?php

use chillerlan\QRCode\QRCode;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
                <h2>Grupo Itens "<?=$model->nome?>"</h2>
            </div>
            <div class="card-body">
                <div class="row no-gutters row-bordered">
                    <div class="d-flex col-md align-items-center">
                        <div class="card-body d-block text-body">
                            <h5>
                                <div class="font-weight-bold mb-4">Alocado? <span class="text-muted font-weight-normal"> <?= $model->isinActivePedidoAlocacao() ? "Sim" : "Não" ?></span></div>
                                <div class="font-weight-bold mb-4">Em Reparação? <span class="text-muted font-weight-normal"> <?= $model->isInActivePedidoReparacao() ? "Sim" : "Não" ?></span></div>
                                <div class="font-weight-bold mb-0">Observações: <span class="text-muted font-weight-normal"><?= $model->notas ?? "<i>Nada a Apresentar.</i>"?></span></div>
                            </h5>
                        </div>
                    </div>
                    <div class="d-flex col-md align-items-center"></div>
                    <div class="d-flex col-md align-items-center">
                        <div class="card-body d-block text-body text-center">
                            <img src="<?= (new QRCode())->render("GRUPO_" . $model->id)?>">
                        </div>
                    </div>
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
