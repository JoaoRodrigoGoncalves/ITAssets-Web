<?php

use chillerlan\QRCode\QRCode;
use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\Item $item */
/** @var array $historicoItem */
/** @var array $historyProvider */

$this->title = $item->nome;
$this->params['breadcrumbs'][] = ['label' => 'Itens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container flex-grow-1 container-p-y mt-3">
    <div class="card">
        <div class="card-header bg-info">
            <h2>Item "<?= Html::encode($this->title) ?>"</h2>
        </div>
        <div class="card-body">
            <div class="row no-gutters row-bordered">
                <div class="d-flex col-md align-items-center">
                    <div class="card-body d-block text-body">
                        <h5>
                            <div class="font-weight-bold mb-4">Categoria: <span class="text-muted font-weight-normal"> <?= $item->categoria->nome ?? "<i>Sem categoria</i>"?></span></div>
                            <div class="font-weight-bold mb-4">Em Grupo de Itens? <span class="text-muted font-weight-normal"> <?= $item->isInActiveItemsGroup() ? "Sim" : "Não"?></span></div>
                            <?php if(!$item->isInActiveItemsGroup()): ?>
                                <div class="font-weight-bold mb-4">Alocado? <span class="text-muted font-weight-normal"> <?= $item->isInActivePedidoAlocacao() ? "Sim" : "Não"?></span></div>
                                <div class="font-weight-bold mb-4">Em Reparação? <span class="text-muted font-weight-normal"> <?= $item->isInActivePedidoReparacao() ? "Sim" : "Não"?></span></div>
                            <?php endif; ?>
                            <div class="font-weight-bold mb-0">Observações: <span class="text-muted font-weight-normal"><?= $item->notas ?? "<i>Nada a Apresentar.</i>"?></span></div>
                        </h5>
                    </div>
                </div>
                <div class="d-flex col-md align-items-center"></div>
                <div class="d-flex col-md align-items-center">
                    <div class="card-body d-block text-body text-center">
                        <img src="<?= (new QRCode())->render("ITEM_" . $item->id)?>">
                        <div class="font-weight-bold mb-0">Número de Série: <span class="text-muted font-weight-normal"> <?= $item->serialNumber ?? "<i>Sem Número de Série</i>"?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['item/update', 'id' => $item->id], ['class' => 'btn btn-warning text-white']) ?>

                <?= Html::a('<i class="fas fa-trash"></i>', ['item/delete', 'id' => $item->id], [
                    'class' => 'btn btn-danger',
                    'data'=> [
                        'confirm' => 'Tem a certeza que quer eliminar este item?',
                        'method'=> 'POST'
                    ]
                ]) ?>
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