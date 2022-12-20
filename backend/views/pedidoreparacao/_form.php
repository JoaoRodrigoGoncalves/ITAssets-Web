<?php

use common\models\Grupoitens;
use common\models\Item;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */
/** @var yii\widgets\ActiveForm $form */
/** @var ArrayDataProvider $objectosSelecionados */
?>

<div class="card m-5">

    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5>Objetos Selecionados</h5>
                <?php if($objectosSelecionados != null): ?>
                    <?= GridView::widget([
                        'dataProvider' => $objectosSelecionados,
                        'summary' => '',
                        'columns' => [
                            [
                                'label' => 'Nome',
                                'value' => 'nome'
                            ],
                            [
                                'label' => 'Serial',
                                'format' => 'html',
                                'value' => 'serial'
                            ],
                        ]
                    ]);
                    ?>
                <?php endif; ?>

                <?= Html::a("Selecionar Objetos", ['/object-select/index'], ['class' => 'btn btn-primary float-right' ,'data' => [
                    'method' => 'POST',
                    'params' => [
                        'Callback' => '/pedidoreparacao/create',
                        'SearchFor' => [Item::class, Grupoitens::class],
                        'Multiselect' => true,
                        'functionRules' => ['!isInActivePedidoAlocacao', '!isInActiveItemsGroup'],
                    ]
                ]]) ?>
            </li>
            <li class="list-group-item">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'descricaoProblema')->textarea(['rows' => 6]) ?>
            </li>
        </ul>
    </div>

    <div class="card-footer">
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success float-right']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
