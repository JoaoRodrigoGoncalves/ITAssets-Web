<?php

use common\models\PedidoReparacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\PedidoReparacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pedido Reparacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-reparacao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pedido Reparacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dataPedido',
            'dataInicio',
            'dataFim',
            'descricaoProblema:ntext',
            //'requerente_id',
            //'responsavel_id',
            //'status',
            //'respostaObs:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PedidoReparacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
