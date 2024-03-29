<?php

/* @var $this View */
/* @var $content string */

use backend\assets\AppAsset;
use hail812\adminlte3\assets\AdminLteAsset;
use hail812\adminlte3\assets\FontAwesomeAsset;
use yii\helpers\Html;
use yii\web\View;

//FontAwesomeAsset::register($this);
AppAsset::register($this);

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
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
    <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <script type="application/javascript">
            window.addEventListener('load', function() {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Sucesso',
                    icon: 'fas fa-check',
                    body: '<?= Yii::$app->session->getFlash("success") ?>',
                    autohide: true,
                    delay: 3000,
                });
            })
        </script>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <script type="application/javascript">
            window.addEventListener('load', function() {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Atenção!',
                    icon: 'fas fa-check',
                    body: '<?= Yii::$app->session->getFlash("error") ?>',
                    autohide: true,
                    delay: 3000,
                });
            })
        </script>
    <?php endif; ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
