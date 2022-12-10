<?php

/* @var $this View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?> | IT Assets</title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <?php $this->beginBody() ?>

        <div class="wrapper">
            <!-- Navbar -->
            <?= $this->render('navbar') ?>
            <!-- /.navbar -->

            <div class="container-fluid">
                <div class="m-3">
                    <?= $content ?>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>