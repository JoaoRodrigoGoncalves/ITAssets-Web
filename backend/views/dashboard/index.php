<?php

use common\models\PedidoAlocacao;
use common\models\PedidoReparacao;
use common\models\User;
use hail812\adminlte\widgets\InfoBox;
use hail812\adminlte\widgets\SmallBox;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= SmallBox::widget([
                'title' => PedidoAlocacao::find()->where(['status' => PedidoAlocacao::STATUS_ABERTO])->count(),
                'text' => 'Novos Pedidos de Alocação',
                'icon' => 'fas fa-clipboard',
                'theme' => 'success',
                'linkText' => 'Ver Pedidos',
                'linkUrl' => Url::to(['pedidoalocacao/index'])
            ]) ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= SmallBox::widget([
                'title' => PedidoReparacao::find()->where(['status' => PedidoAlocacao::STATUS_ABERTO])->count(),
                'text' => 'Novos Pedidos de Reparação',
                'icon' => 'fas fa-wrench',
                'theme' => 'danger',
                'linkText' => 'Ver Pedidos',
                'linkUrl' => Url::to(['pedidoreparacao/index'])
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= InfoBox::widget([
                    'text' => 'Utilizadores',
                    'number' => User::find()->count(),
                    'icon' => 'fas fa-user',
                    'theme' => 'primary'
            ]) ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <?= InfoBox::widget([
                    'text' => 'Gastos com Reparações (Últimos 5 dias)',
                    'number' => $totalDespesas . "€",
                    'icon' => 'fas fa-euro-sign',
                    'theme' => 'warning'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <canvas id="gastosMeses"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('gastosMeses');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php
                foreach ($dadosGrafico as $dia => $valor) {
                    echo "'" . $dia . "',";
                }
                ?>],
            datasets: [{
                label: '€',
                data: [<?php
                    foreach ($dadosGrafico as $dia => $valor) {
                        echo "'" . $valor . "',";
                    }
                    ?>],
                borderWidth: 1
            }]
        },
        options: {
            aspectRatio: 3/1.3,
            maintainAspectRatio: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Total Gasto em Reparações por Dia'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>