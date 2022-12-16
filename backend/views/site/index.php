<?php

use common\models\Site;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SiteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Locais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-3">
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-location"></i> Registar', ['create'], ['class' => 'btn btn-primary']) ?>
            <div class="float-right">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
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
                        'value' => 'nome'
                    ],
                    [
                        'label' => 'Morada',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->rua != null)
                            {
                                return $data->rua . ", " . $data->codPostal . " " . $data->localidade;
                            }
                            else
                            {
                                return "<i>Não Aplicável</i>";
                            }
                        }
                    ],
                    [
                        'label' => 'Coordenadas',
                        'format' => 'html',
                        'value' => function($data)
                        {
                            if($data->coordenadas != null)
                            {
                                return $data->coordenadas;
                            }
                            else
                            {
                                return "<i>Não Aplicável</i>";
                            }
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => ['style' => 'width: 1%; white-space: nowrap;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-eye"></i>', ['site/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                            },
                            'update' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-pencil-alt"></i>', ['site/update', 'id' => $model->id], ['class' => 'btn btn-warning text-white']);
                            },
                            'delete' => function($url, $model)
                            {
                                return Html::a('<i class="fas fa-trash-alt"></i>', ['site/delete', 'id' => $model->id], ['class' => 'btn btn-danger']);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
