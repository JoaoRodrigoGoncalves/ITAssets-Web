<?php

use common\models\Grupoitens;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Grupoitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupoitens-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Grupoitens', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?=
             GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],


                    'id',
                    'nome',
                    'notas:ntext',
                    'status',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Grupoitens $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]);

    ?>


</div>
