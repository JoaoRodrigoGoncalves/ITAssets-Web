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
            <div class="row">
                <div class="col-2">
                    <?= Html::a('Criar Local', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="col-10">
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{items}\n{summary}\n{pager}",
                'columns' => [
                    'nome',
                    [
                        'label' => 'Morada',
                        'value' => function($data)
                        {
                            if($data->rua != null)
                            {
                                return $data->rua . ", " . $data->codPostal . " " . $data->localidade;
                            }
                            else
                            {
                                return "N/A";
                            }
                        }
                    ],
                    [
                        'label' => 'Coordenadas',
                        'value' => function($data)
                        {
                            if($data->coordenadas != null)
                            {
                                return $data->coordenadas;
                            }
                            else
                            {
                                return "N/A";
                            }
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Site $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                         }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
