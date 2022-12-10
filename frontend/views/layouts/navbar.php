<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= Url::to(['dashboard/index']) ?>">
                <?= Html::img('@web/img/gatocaixabranco.png', ['alt'=>'Logotipo', 'class'=>'d-inline-block align-top', 'width'=>'30','height'=>'30']);?>
                ItAssets
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Pedidos Reparação</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['pedidoalocacao/index']) ?>">Pedido Alocação</a>
                </li>
            </ul>
        </div>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-gear"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Ver detalhes</a></li>
                <li class="dropdown-divider"></li>
                <li>
                    <?= Html::a('<i class="fa-solid fa-right-from-bracket"></i> Sair', ['site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
    </ul>
</nav>
