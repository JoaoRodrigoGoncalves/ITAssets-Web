<?php

use yii\helpers\Html;

?>
<!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">ItAssets</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Pedidos Reparação</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pedido Alocação</a>
            </li>

        </ul>

        <a href=""></a>
        <?/*=
        Html::beginForm(['/site/logout'], 'post', ['class' => 'btn btn-info d-flex'])
        . Html::submitButton(Yii::$app->user->identity->username ,
            ['class' => 'btn btn-link text-light']
        )
        . Html::endForm();
        */?>
    </div>
</nav>-->



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
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-gear"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user"></i> Ver detalhes

                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair

                </a>

            </div>
        </li>
    </ul>
    <?=
        Html::beginForm(['/site/logout'], 'post', ['class' => 'btn btn-info d-flex'])
        . Html::submitButton(Yii::$app->user->identity->username ,
            ['class' => 'btn btn-link text-light']
        )
        . Html::endForm();
        ?>
</nav>
