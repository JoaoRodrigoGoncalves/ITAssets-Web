
<?php

use backend\models\Utilizador;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var User[] $utilizadores */

$this->title = "Gestão de Utilizadores";
?>
<div class="container mt-3">
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
                        <th style="width: 1%; white-space: nowrap;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilizadores as $utilizador)

                        if ($utilizador->status != 0){?>
                        <tr>
                            <td><?=$utilizador->username?></td>
                            <td><?=$utilizador->email?></td>
                            <td>
                                <?= "<span class='badge badge-info'>" . Utilizador::getRoleLabel($utilizador->getRole()->name) . "</span>" ?>
                            </td>
                            <td>
                                <?= $utilizador->getStatusLabel() ?>
                            </td>
                            <td class="btn-group">
                                <?= Html::a('<i class="fas fa-user"></i>', ['utilizador/view', 'id' => $utilizador->id], ['class' => 'btn btn-primary mr-1']) ?>
                                <?php if(Yii::$app->user->can('writeUtilizador')): ?>
                                    <?= Html::a('<i class="fas fa-pencil-alt text-white"></i>', ['utilizador/update/', 'id' => $utilizador->id], ['class' => 'btn btn-warning mr-1']) ?>
                                    <?php
                                        if($utilizador->id == Yii::$app->user->id)
                                        {
                                            echo Html::button("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_off</span>", ['class' => 'btn btn-danger pb-0', 'disabled' => 'disabled']);
                                        }
                                        else
                                        {
                                            if($utilizador->status == 10)
                                            {
                                                echo Html::a("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_off</span>", ['utilizador/activar', 'id' => $utilizador->id], ['class' => 'btn  btn-danger pb-0']);
                                            }
                                            else
                                            {
                                                echo Html::a("<span class='material-symbols-outlined' style='font-variation-settings: \"FILL\" 1, \"wght\" 400, \"GRAD\" 200, \"opsz\" 20; padding-bottom: 0;'>toggle_on</span>", ['utilizador/activar', 'id' => $utilizador->id], ['class' => 'btn  btn-success pb-0']);
                                            }
                                        }
                                    ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

