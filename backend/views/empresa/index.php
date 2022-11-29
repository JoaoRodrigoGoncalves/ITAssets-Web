<?php

use common\models\Empresa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Empresa $empresa */
?>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-3 py-4">
                <div class="text-center">
                    <?= Html::img('@web/img/empresa2.jpg', ['alt'=>'some', 'class'=>'rounded-circle','width'=>'200']);?>
                </div>
                <div class="text-center mt-3">
                    <h3 class="mt-2 mb-0"><?=$empresa->nome?></h3>
                    <hr>
                    <div class="card-block">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600"><strong>Informação</strong></h6>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600">Nif</p>
                                <h6 class="text-muted f-w-400"><?=$empresa->NIF?></h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600">Morada</p>
                                <h6 class="text-muted f-w-400"><?=$empresa->rua?>, <?=$empresa->codigoPostal?>,<br><?=$empresa->localidade?></h6>
                            </div>
                        </div>
                        <br>
                        <a href="<?=Url::to(['empresa/update']) ?>" class="btn btn-secondary">Editar Dados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
