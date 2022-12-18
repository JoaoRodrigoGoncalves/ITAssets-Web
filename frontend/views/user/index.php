<?php

use common\models\User;
use hail812\adminlte\widgets\SmallBox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="container-fluid">
        <div class="row ">
            <div class="container col-xxl-12 px-4 py-5 col-md-8">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <h1 class="profile-username text-center"><?= $user->username ?></h1>

                        <p class="text-muted text-center"><?= $user->email ?></p>


                    </div>

                    <!-- /.card-body -->
                </div>
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <h3>Dados do Utilizador</h3>
                            <?php $form = ActiveForm::begin(['id' => 'settings-form', 'action' => '/user/save']) ?>

                            <?= $form->field($user,'username', [
                                'options' => ['class' => 'form-group has-feedback'],
                                'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                                'template' => '{beginWrapper}{label}{input}<div class="col-sm-2"></div>{error}{endWrapper}',
                                'errorOptions' => ['class' => 'invalid-feedback d-block col-sm-10'],
                                'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                                'wrapperOptions' => ['class' => 'form-group row']
                            ])
                                ->textInput(['placeholder' => $user->getAttributeLabel('username')]) ?>

                            <?= $form->field($user,'email', [
                                'options' => ['class' => 'form-group has-feedback'],
                                'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                                'template' => '{beginWrapper}{label}{input}<div class="col-sm-2"></div>{error}{endWrapper}',
                                'errorOptions' => ['class' => 'invalid-feedback d-block col-sm-10'],
                                'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                                'wrapperOptions' => ['class' => 'form-group row']
                            ])
                                ->textInput(['placeholder' => $user->getAttributeLabel('email')]) ?>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>

                            <?php $passwordForm = ActiveForm::begin(['action' => '/user/password', 'class' => 'form-group' ]) ?>

                            <?= $passwordForm->field($password,'old_password', [
                                'options' => ['class' => 'form-group has-feedback'],
                                'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                                'template' => '{beginWrapper}{label}{input}<div class="col-sm-2"></div>{error}{endWrapper}',
                                'errorOptions' => ['class' => 'invalid-feedback d-block col-sm-10'],
                                'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                                'wrapperOptions' => ['class' => 'form-group row']
                            ])
                                ->passwordInput(['placeholder' => $password->getAttributeLabel('old_password')]) ?>

                            <?= $passwordForm->field($password,'new_password', [
                                'options' => ['class' => 'form-group has-feedback'],
                                'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                                'template' => '{beginWrapper}{label}{input}<div class="col-sm-2"></div>{error}{endWrapper}',
                                'errorOptions' => ['class' => 'invalid-feedback d-block col-sm-10'],
                                'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                                'wrapperOptions' => ['class' => 'form-group row']
                            ])
                                ->passwordInput(['placeholder' => $password->getAttributeLabel('new_password')]) ?>

                            <?= $passwordForm->field($password,'repeat_password', [
                                'options' => ['class' => 'form-group has-feedback'],
                                'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                                'template' => '{beginWrapper}{label}{input}<div class="col-sm-2"></div>{error}{endWrapper}',
                                'errorOptions' => ['class' => 'invalid-feedback d-block col-sm-10'],
                                'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                                'wrapperOptions' => ['class' => 'form-group row']
                            ])
                                ->passwordInput(['placeholder' => $password->getAttributeLabel('repeat_password')]) ?>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <?= Html::submitButton('Alterar', ['class' => 'btn btn-danger']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end() ?>



                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>