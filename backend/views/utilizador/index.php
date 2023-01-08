
<?php

use backend\models\Utilizador;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Gestão de Utilizadores";
?>
<div class="container mt-3">
    <h2>Gestão de Utilizadores</h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-plus"></i> Registar', ['create'], ['class' => 'btn btn-primary float-right']) ?>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{items}\n{summary}\n{pager}",
                'emptyText' => "Sem dados a mostrar.",
                'summary' => "A apresentar de <b>{begin}</b> a <b>{end}</b> de <b>{totalCount}</b> registos.",
                'columns' => [
                    [
                        'label' => 'Nome',
                        'value' => 'username'
                    ],
                    [
                        'label' => 'Email',
                        'value' => 'email'
                    ],
                    [
                        'label' => 'Tipo de Utilizador',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            return "<span class='badge badge-info'>" . Utilizador::getRoleLabel($data->getRole()->name) . "</span>";
                        }
                    ],
                    [
                        'label' => 'Estado',
                        'format' => 'html',
                        'value' => function($data) {
                            return $data->getStatusLabel();
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-eye"></i>', ['utilizador/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                if (Yii::$app->user->can('writeUtilizador')) {
                                    return Html::a('<i class="fas fa-pencil-alt text-white"></i>', ['utilizador/update', 'id' => $model->id], ['class' => 'btn btn-warning mr-1']);
                                }
                            },
                            'delete' => function($url, $model)
                            {
                                if (Yii::$app->user->can('writeUtilizador')) {
                                    if($model->id == Yii::$app->user->id)
                                    {
                                        return Html::button("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_off</span>", ['class' => 'btn btn-danger pb-0', 'disabled' => 'disabled']);
                                    }
                                    else
                                    {
                                        if($model->status == User::STATUS_ACTIVE)
                                        {
                                            return Html::a("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_off</span>", ['utilizador/activar', 'id' => $model->id], [
                                                    'class' => 'btn  btn-danger pb-0',
                                                    'data'=> [
                                                        'confirm' => 'Tem a certeza que quer desativar este utilizador?'
                                                    ]
                                            ]);
                                        }
                                        else
                                        {
                                            return Html::a("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_on</span>", ['utilizador/activar', 'id' => $model->id], ['class' => 'btn  btn-success pb-0']);
                                        }
                                    }
                                }
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

