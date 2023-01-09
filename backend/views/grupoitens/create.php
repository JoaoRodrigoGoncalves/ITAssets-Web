<?php

use common\models\Item;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Grupoitens $model */
/** @var yii\widgets\ActiveForm $form */
/** @var string $itensSelecionados_string */
/** @var array $itensSelecionados */

$this->title = 'Registo Grupos de Itens';
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Itens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container grupoitens-form card">
    <div class="card-body">

        <?php
        /* Critétios para os itens que pode sem apresentados para adicionar a um grupo:

            1 - Não pode fazer parte de outro grupo
            2 - Não pode estar alocado a um utilizador
            3 - Pode ter sido alocado anteriormente ou estar num pedido pendente
                    Pode ter sido ABERTO, NEGADO, DEVOLVIDO, CANCELADO.
                    Não pode estar em APROVADO

        */

        $objectSelectorConfig = [
            'Callback' => '/grupoitens/create/',
            'SearchFor' => [
                [
                    'model' => Item::class,
                    'functionRules' => [
                        [
                            'function' => '!isInActiveItemsGroup',
                        ],
                        [
                            'function' => '!isInActivePedidoAlocacao',
                        ],
                    ]
                ],
            ],
            'Multiselect' => true,
        ];

        echo Html::a('<i class="fa-solid fa-hand-pointer"></i> Selecionar Itens', ['/object-select/index'], ['class' => 'btn btn-primary mb-2', 'data' => [
            'method' => 'POST',
            'params' => ['config' => json_encode($objectSelectorConfig)]
        ]]);

        if($itensSelecionados != null)
        {
            echo "<h4>Itens Selecionados:</h4>";
            echo GridView::widget([
                'dataProvider' => $itensSelecionados,
                'summary' => '',
                'columns' => [
                    [
                        'label' => 'Nome',
                        'value' => 'nome'
                    ],
                    [
                        'label' => 'Informações Adicionais',
                        'value' => 'info_adicional'
                    ],
                ]
            ]);
        }
        else
        {
            echo "<p>Não existem objetos selecionados</p>";
        }
        ?>

        <?php $form = ActiveForm::begin(); ?>

        <input type="hidden" name="selectedItems" value="<?= $itensSelecionados_string ?>">

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-lg btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>