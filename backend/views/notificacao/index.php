<?php
/** @var yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Notificações";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card ms-2 me-2 mt-5">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <h1>Notificações</h1>
            </div>
            <div class="col">
                <?= Html::a("Marcar tudo como lido", ['notificacao/marcarlido'], ['class' => 'btn btn-primary float-right']) ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=> "{items}\n{summary}\n{pager}",
            'emptyText' => "Sem notificações a mostrar.",
            'summary' => "A apresentar de <b>{begin}</b> a <b>{end}</b> de <b>{totalCount}</b> notificações.",
            'columns' => [
                [
                    'label' => "",
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                    'value' => function($data)
                    {
                        if(!$data->read)
                        {
                            return '<span class="badge-pill bg-warning">Nova</span>';
                        }
                        return "<span class='badge-pill bg-success'>Lida</span>";
                    }
                ],
                [
                    'attribute' => 'datetime',
                    'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                ],
                'message'
            ],
        ]); ?>
    </div>
</div>
