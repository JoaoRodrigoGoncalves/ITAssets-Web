<?php

use common\models\Grupoitens;
use common\models\Item;
use common\models\User;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PedidoReparacao $model */
/** @var yii\widgets\ActiveForm $form */
/** @var ArrayDataProvider $objectosSelecionados */
/** @var string $objectosSelecionados_string */

$this->title = 'Criar Novo Pedido de Reparação';
$this->params['breadcrumbs'][] = ['label' => 'Pedido Reparacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card m-5">

    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5>Objetos Selecionados</h5>

                <?php

                    $objectSelectorConfig = [
                        'Callback' => '/pedidoreparacao/create',
                        'SearchFor' => [
                            [
                                'model' => Item::class,
                                'functionRules' => [
                                    [
                                        'function' => 'isAlocatedToUser',
                                        'args' => [Yii::$app->user->id]
                                    ],
                                    [
                                        'function' => '!isInActiveItemsGroup',
                                    ],
                                    [
                                        'function' => '!isInActivePedidoReparacao',
                                    ],
                                ]
                            ],
                            [
                                'model' => Grupoitens::class,
                                'functionRules' => [
                                    [
                                        'function' => 'isAlocatedToUser',
                                        'args' => [Yii::$app->user->id]
                                    ],
                                    [
                                        'function' => '!isInActivePedidoReparacao',
                                    ],
                                ]
                            ]
                        ],
                        'Multiselect' => true,
                    ];

                ?>

                <?= Html::a("Selecionar Objetos", ['/object-select/index'], ['class' => 'btn btn-primary mb-2' ,'data' => [
                    'method' => 'POST',
                    'params' => ['config' => json_encode($objectSelectorConfig)]
                ]]) ?>

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
                                'value' => 'serial'
                            ],
                        ]
                    ]);
                    ?>
                <?php else: ?>
                    <p>Não existem objetos selecionados</p>
                <?php endif; ?>
            </li>
            <li class="list-group-item">
                <?php $form = ActiveForm::begin(); ?>

                <input type="hidden" name="objectosSelecionados_string" value="<?= $objectosSelecionados_string ?>">

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

