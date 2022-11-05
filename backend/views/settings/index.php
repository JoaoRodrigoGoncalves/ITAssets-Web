<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = "Definições";
?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <h3 class="profile-username text-center"><?= $user->username ?></h3>

                        <p class="text-muted text-center"><?= $user->email ?></p>

                        <div class="text-center">
                            <?php
                                foreach(Yii::$app->authManager->getRolesByUser($user->id) as $role)
                                {
                                    echo "<span class='badge badge-info'>" . ucfirst($role->name) . "</span>";
                                }
                            ?>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3 mt-2">
                            <li class="list-group-item">
                                <b>Itens</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Alocação</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Reparação</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h3>Dados do Utilizador</h3>
                        <?php $form = ActiveForm::begin(['id' => 'settings-form', 'action' => '/settings/save']) ?>

                        <?= $form->field($user,'username', [
                            'options' => ['class' => 'form-group has-feedback'],
                            'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                            'template' => '{beginWrapper}{label}{input}{error}{endWrapper}',
                            'labelOptions' => ['class' => 'col-sm-2 col-form-label'],
                            'wrapperOptions' => ['class' => 'form-group row']
                        ])
                            ->textInput(['placeholder' => $user->getAttributeLabel('username')]) ?>

                        <?= $form->field($user,'email', [
                            'options' => ['class' => 'form-group has-feedback'],
                            'inputTemplate' => '<div class="col-sm-10">{input}</div>',
                            'template' => '{beginWrapper}{label}{input}{error}{endWrapper}',
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

                        <h3>Alterar Palavra-passe</h3>


                        <?php ActiveForm::begin(['action' => '/settings/update', 'class' => 'form-group' ]) ?>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Palavra-passe atual</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="old_password" placeholder="Palavra-passe atual">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nova palavra-passe</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="new_password" placeholder="Nova palavra-passe">
                                </div>
                            </div>

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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>