<?php


/** @var yii\web\View $this */
/** @var common\models\PedidoAlocacao $model */

use common\models\PedidoAlocacao;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Aprovação de alocação de item';
$this->params['breadcrumbs'][] = ['label' => 'Pedidos Alocação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Pedido Nº' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h2><?= $this->title ?></h2>
    <br>
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <table class="table table-bordered">
                <tr>
                    <td style="width: 1%; white-space: nowrap">Item Requesitado:</td>
                    <td>
                        <?php
                            if($model->item != null)
                            {
                                echo Html::a($model->item->nome, ['item/view', 'id' => $model->item->id]);
                            }
                            else
                            {
                                echo Html::a($model->grupoItem->nome, ['grupoitens/view', 'id' => $model->grupoItem->id]);
                            }
                        ?>
                    </td>
                </tr>
            </table>

            <?= $form->field($model, 'status')->radioList([PedidoAlocacao::STATUS_APROVADO => 'Aprovar', PedidoAlocacao::STATUS_NEGADO => 'Negar'], ['required' => true]) ?>

            <?= $form->field($model, 'obsResposta')->textarea() ?>

            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
