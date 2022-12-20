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
?>

<div class="card m-5">

    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5>Objetos Selecionados</h5>
                <?= Html::a("Selecionar Objetos", ['/object-select/index'], ['class' => 'btn btn-primary mb-2' ,'data' => [
                    'method' => 'POST',
                    'params' => [
                        'Callback' => '/pedidoreparacao/create',
                        'SearchFor' => [Item::class, Grupoitens::class],
                        'Multiselect' => true,
                        'functionRules' => ['!isInActivePedidoAlocacao', '!isInActiveItemsGroup', '!isInActivePedidoReparacao'],
                    ]
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

                <?php
                $array_users = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->orderBy('username')->all(), 'id', function($userModel)
                {
                    return $userModel['username'] . " (" . $userModel['email'] . ")";
                });
                ?>

                <?= $form->field($model, 'requerente_id')->dropDownList($array_users, ['prompt' => '- Selecione um utilizador -']) ?>

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
