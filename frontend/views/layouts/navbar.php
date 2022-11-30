<?php

use yii\helpers\Html;

?>
<nav class="navbar navbar-expand navbar-dark navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <a class="navbar-brand" href="#">

            <?= Html::img('@web/images/gatocaixabranco.png', ['alt'=>'some', 'class'=>'d-inline-block align-top', 'width'=>'30','height'=>'30']);?>
            ItAssets
        </a>
        <li class="nav-item">
            <a class="nav-link" href="#">Pedidos Reparação</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Pedido Alocação</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">

            <a class="nav-link" data-toggle="dropdown" href="#"><i class="fas fa-gear"></i></a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-divider"></div>

                <div class="dropdown-item">
                    <a class="btn"><i class="fas fa-user"></i> Ver detalhes</a>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-item">
                    <?=
                    Html::beginForm(['/login/logout'])?>
                        <button type="submit" class="btn"><i class="fa-solid fa-right-from-bracket"></i> Sair</button>
                    <?=Html::endForm();
                    ?>
                </div>
            </div>
        </li>
    </ul>

</nav>
