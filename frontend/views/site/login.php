<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var Login $model */

use common\models\Login;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';

?>
<div class="mt-lg-5">
<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <?= Html::img('@web/img/gatocaixabranco.png', ['alt'=>'Logotipo', 'class'=>'img-fluid float-center']); ?>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <h1 class="d-flex justify-content-center mt-lg-5"><?= Html::encode($this->title) ?></h1>
                        <div class="card-body py-5 px-md-5">
                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>


                            <p><?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?></p>


                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <p class="small mb-5 pb-lg-2"><?= $form->field($model, 'rememberMe')->checkbox() ?></p>

                            <div class="form-group">
                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
</div>