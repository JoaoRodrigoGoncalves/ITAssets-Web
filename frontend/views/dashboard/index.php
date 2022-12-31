<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var \yii\data\ActiveDataProvider $dataProvider */

?>
<?= Html::a("Marcar tudo como lido", ['dashboard/marcarlido'], ['class' => 'btn btn-primary float-right']) ?>
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