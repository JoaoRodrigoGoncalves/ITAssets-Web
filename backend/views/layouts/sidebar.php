<?php

use hail812\adminlte\widgets\Menu;
use yii\helpers\Url;

/** @var false|string $assetDir */
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['dashboard/index']) ?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">IT Assets</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= Url::to(['settings/index']) ?>" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php

            echo Menu::widget([
                'items' => [
                    ['label' => 'Itens', 'icon' => 'box', 'url' => '/item/index'],
                    ['label' => 'Grupos Itens', 'icon' => 'boxes', 'url' => '#'],
                    ['label' => 'Pedidos de Alocação', 'icon' => 'clipboard', 'url' => '/pedidoalocacao/index'],
                    ['label' => 'Pedidos de Reparação', 'icon' => 'wrench', 'url' => '#'],
                    ['label' => 'Utilizadores', 'icon' => 'users', 'url' => '/utilizador/index'],
                    ['label' => 'Locais', 'icon' => 'map-marker-alt', 'url' => '/site/index'],
                    ['label' => 'Categorias', 'icon' => 'stream', 'url' => '/categoria/index'],
                    ['label' => 'Empresa', 'icon' => 'building', 'url' => '/empresa/index'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>