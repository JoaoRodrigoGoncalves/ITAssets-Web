<?php
/** @var User $utilizador */

use common\models\User;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = "Detalhes de " . $utilizador->username;
?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <h3 class="profile-username text-center"><?= $utilizador->username ?></h3>

                        <p class="text-muted text-center"><?= $utilizador->email ?></p>

                        <div class="text-center">
                            <?= "<span class='badge badge-info'>" . ucfirst($utilizador->getRole()->name) . "</span>" ?>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3 mt-2">
                            <li class="list-group-item">
                                <b>Estado</b> <a class="float-right"><?= $utilizador->getStatusLabel() ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Itens Alocados</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Alocação</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Reparação</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>

                        <?php if(Yii::$app->user->can('writeUtilizador')): ?>
                            <div class="btn-toolbar d-flex justify-content-center" role="toolbar">
                                <?= Html::a('<i class="fas fa-key"></i>', ['utilizador/resetpassword/', 'id' => $utilizador->id], ['class' => 'btn btn-primary m-1']) ?>
                                <?= Html::a('<i class="fas fa-pencil-alt text-white"></i>', ['utilizador/update/', 'id' => $utilizador->id], ['class' => 'btn btn-warning m-1']) ?>
                                <?php if($utilizador->id != Yii::$app->user->id): ?>
                                    <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#removeUserModal"><i class="fas fa-trash-alt"></i></button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger m-1" disabled><i class="fas fa-trash-alt"></i></button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="userProfileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="itens-tab" data-toggle="tab" data-target="#itens" type="button" role="tab" aria-controls="home" aria-selected="true">Itens Associados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="alocacao-tab" data-toggle="tab" data-target="#alocacao" type="button" role="tab" aria-controls="profile" aria-selected="false">Pedidos de Alocação</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reparacao-tab" data-toggle="tab" data-target="#reparacao" type="button" role="tab" aria-controls="contact" aria-selected="false">Pedidos de Reparação</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="userProfileTabContent">
                            <div class="tab-pane fade show active" id="itens" role="tabpanel" aria-labelledby="itens-tab">
                                ...<br>
                                Tabela de itens associados<br>
                                ...
                            </div>
                            <div class="tab-pane fade" id="alocacao" role="tabpanel" aria-labelledby="alocacao-tab">
                                ...<br>
                                Tabela de pedidos de itens<br>
                                ...
                            </div>
                            <div class="tab-pane fade" id="reparacao" role="tabpanel" aria-labelledby="reparacao-tab">
                                ...<br>
                                Tabela de pedidos de reparação de itens<br>
                                ...
                            </div>
                        </div>

                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <?php if(in_array(Yii::$app->authManager->getRole("administrador"), Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))): ?>
        <!-- Modal -->
        <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="removeUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeUserModalLabel">Remover utilizador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem a certeza que pretende apagar permanentemente o utilizador "<?= $utilizador->username ?>" (<?= $utilizador->email ?>)?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <?= Html::a('<i class="fas fa-trash-alt"></i> Remover Utilizador', ['utilizador/delete/', 'id' => $utilizador->id], ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>