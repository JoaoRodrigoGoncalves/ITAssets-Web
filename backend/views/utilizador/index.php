
<?php

use backend\models\Utilizador;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\User[] $utilizadores */

$this->title = "Gestão de Utilizadores";
?>
<div class="container mt-5">
    <h2>Gestão de Utilizadores</h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('<i class="fas fa-user-plus"></i> Registar', ['create'], ['class' => 'btn btn-primary float-right']) ?>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tipo de Utilizador</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilizadores as $utilizador)

                        if ($utilizador->status != 0){?>
                        <tr>
                            <td><?=$utilizador->username?></td>
                            <td><?=$utilizador->email?></td>
                            <td>
                                <?php
                                    foreach(Yii::$app->authManager->getRolesByUser($utilizador->id) as $role)
                                    {
                                        echo "<span class='badge badge-info'>" . Utilizador::getRoleLabel($role->name) . "</span>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?= $utilizador->getStatusLabel() ?>
                            </td>
                            <td>
                                <div class="justify-content-center btn-group">
                                    <?= Html::a('<i class="fas fa-user"></i>', ['utilizador/view', 'id' => $utilizador->id], ['class' => 'btn btn-primary mr-2']) ?>
                                    <?= Html::a('<i class="fas fa-pencil-alt text-white"></i>', ['utilizador/update/', 'id' => $utilizador->id], ['class' => 'btn btn-warning mr-2']) ?>


                                </div>
                            </td>
                            <td class="row">
                                <div class="btn-group col-sm-12">
                                <?php
                                foreach(Yii::$app->authManager->getRolesByUser($utilizador->id) as $role)
                                {
                                    if($role->name=="administrador"){
                                        //butao par aos admins?>

                                        <button class="btn btn-danger btn-block" disabled>Desativar</button>
                                    <?php }else{?>
                                        <div>
                                            <?php
                                            if($utilizador->status == 10) {
                                                //desativar
                                                echo Html::a('Desativar', ['utilizador/activar', 'id' => $utilizador->id], ['class' => 'btn btn-danger']);

                                            }else if($utilizador->status == 9) {
                                                //ativar
                                                echo Html::a(' Ativar ', ['utilizador/activar', 'id' => $utilizador->id], ['class' => 'btn btn-success w-100 d-block']);
                                            }
                                            ?>
                                        </div>
                                    <?php }
                                }
                                ?>

                                </div>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

