<?php

use common\models\PedidoAlocacao;
use hail812\adminlte\widgets\SmallBox;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <!-- TODO: Colocar titulo dinâmico com os valores dos pedidos abertos -->
    <?php
        $pedidosAlocacao = PedidoAlocacao::find()->where(['status' => PedidoAlocacao::STATUS_ABERTO])->count();
    ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= SmallBox::widget([
                'title' => $pedidosAlocacao,
                'text' => 'Novos Pedidos de Alocação',
                'icon' => 'fas fa-clipboard',
                'theme' => 'success',
                'linkText' => 'Ver Pedidos',
                'linkUrl' => Url::to(['pedidoalocacao/index'])
            ]) ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= SmallBox::widget([
                'title' => '150',
                'text' => 'Novos Pedidos de Reparação',
                'icon' => 'fas fa-wrench',
                'theme' => 'danger',
                'linkText' => 'Ver Pedidos',
                'linkUrl' => Url::to(['dashboard/index'])
            ]) ?>
        </div>
    </div>
</div>