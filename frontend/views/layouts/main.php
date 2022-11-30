<?php

/* @var $this View */
/* @var $content string */

use yii\helpers\Html;
use yii\web\View;

// Google Font: Source Sans Pro
$this->registerCssFile("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback");

$this->registerJsFile("https://code.jquery.com/jquery-3.3.1.slim.min.js", ['integrity' => 'sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo', 'crossorigin' => 'anonymous']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js", ['integrity' => 'sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49', 'crossorigin' => 'anonymous']);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js", ['integrity' => 'sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy', 'crossorigin' => 'anonymous']);
$this->registerJsFile("https://kit.fontawesome.com/79a649e6a6.js");

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
        <?=
        Html::cssFile('@web/css/adminlte.css');
        Html::cssFile('@web/css/sweetalert2.min.css');
        Html::jsFile('@web/js/adminlte.min.js');
        ?>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->render('navbar') ?>
        <!-- /.navbar -->

        <!-- Main Footer -->
        <?= $this->render('footer') ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>