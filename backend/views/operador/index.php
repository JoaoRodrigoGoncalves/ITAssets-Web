<?php

use common\models\Empresa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<div class="container mt-5">
    <h2>Gestão de Utilizadores</h2>
    <br>
    <div class="card">
        <div class="card-header">
            <?= Html::a('Registar', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tipo de Utilizador</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($utilizador as $utilizadores){
                    ?>
                    <tr>
                        <td><?=$utilizadores->username?></td>
                        <td><?=$utilizadores->email?></td>
                        <td>
                            <?php
                            foreach(Yii::$app->authManager->getRolesByUser($utilizadores->id) as $role)
                            {
                                echo "<span class='badge badge-dark'>" . ucfirst($role->name) . "</span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
