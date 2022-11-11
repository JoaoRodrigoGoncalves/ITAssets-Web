
<?php

use backend\models\Utilizador;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\User[] $utilizadores */
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
                    <?php foreach ($utilizadores as $utilizador){ ?>
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
                                <a href="" class="btn btn-success"><i class="fas fa-user-edit"></i></a>
                                <a href="" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

