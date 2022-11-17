<?php
/** @var \backend\models\Utilizador $utilizador */

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
                            <?php
                            foreach(Yii::$app->authManager->getRolesByUser($utilizador->id) as $role)
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

                        <?php



                        ?>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>

                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>