<?php

use Carbon\Carbon;
use common\models\Notificacoes;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <?php $notificacoes_nao_lidas = Notificacoes::find()->where(['user_id' => Yii::$app->user->id, 'read' => false])->orderBy(['id' => SORT_DESC])->all(); ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php if(count($notificacoes_nao_lidas) > 0): ?>
                    <span class="badge badge-warning navbar-badge" id="badge-num-notifications"><?= count($notificacoes_nao_lidas) ?></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                <span class="dropdown-header"><?= count($notificacoes_nao_lidas) . ngettext(" Nova Notificação", " Novas Notificações", count($notificacoes_nao_lidas)) ?></span>
                <div class="dropdown-divider"></div>
                <?php if(count($notificacoes_nao_lidas) > 0): ?>
                    <?=
                        Html::a('<i class="fas fa-check"></i> Marcar como lidas',FALSE, [
                        'onclick'=>"
                            $.ajax({
                            type: 'POST',
                            url:  '/notificacao/marcarlido',
                        
                            success: function(response) {
                                $('#badge-num-notifications').remove();
                            }
                        
                            });
                            return false;",
                        'class' => ['dropdown-header']
                        ]);
                    ?>
                    <div class="dropdown-divider"></div>
                <?php endif; ?>
                <?php foreach ($notificacoes_nao_lidas as $notificacao): ?>
                    <a href="<?= $notificacao->link ?? '#' ?>" class="dropdown-item">
                        <?= $notificacao->message ?>
                        <span class="float-right text-muted text-sm"><?= Carbon::parse($notificacao->datetime)->locale('pt_PT')->diffForHumans() ?></span>
                    </a>
                    <div class="dropdown-divider"></div>
                <?php endforeach; ?>
                <a href="<?= Url::to(['notificacao/index']) ?>" class="dropdown-item dropdown-footer">Ver Tudo</a>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/login/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
    </ul>
</nav>
<!-- /.navbar -->