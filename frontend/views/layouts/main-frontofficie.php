<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;


?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/adminlte.css">
        <!-- Font Awesome -->


        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="/css/sweetalert2.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="/css/toastr.min.css">

        <script src="https://kit.fontawesome.com/79a649e6a6.js" crossorigin="anonymous"></script>
        <script src="assets/6fbba6df/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/assets/6fbba6df/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/assets/6fbba6df/adminlte.min.js"></script>

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

        <!-- Main Footer -->
        <?= $this->render('footer') ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>