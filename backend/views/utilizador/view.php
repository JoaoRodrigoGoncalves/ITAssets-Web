<?php
/** @var User $utilizador */

use common\models\PedidoAlocacao;
use common\models\User;
use yii\bootstrap4\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = $utilizador->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                                <b>Itens Alocados</b> <a class="float-right"><?= $utilizador->getPedidosAlocacaoAsRequester()->where(['status' => PedidoAlocacao::STATUS_APROVADO])->count() ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Alocação</b> <a class="float-right"><?= count($utilizador->pedidosAlocacaoAsRequester) ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Pedidos Reparação</b> <a class="float-right"><?= count($utilizador->pedidosReparacaoAsRequester) ?></a>
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
                                <?= GridView::widget([
                                    'dataProvider' => new ArrayDataProvider([
                                            'allModels' => $utilizador->getPedidosAlocacaoAsRequester()->where(['status' => PedidoAlocacao::STATUS_APROVADO])->all()
                                    ]),
                                    'layout'=> "{items}",
                                    'emptyText' => "Sem registos a mostrar.",
                                    'columns' => [
                                        [
                                            'label' => 'Nº Pedido',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                return Html::a($data->id, ['pedidoalocacao/view', 'id' => $data->id]);
                                            }
                                        ],
                                        'dataInicio',
                                        [
                                            'label' => 'Item',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                if($data->item_id != null)
                                                {
                                                    return Html::a($data->item->nome, ['item/view', 'id' => $data->item->id]);
                                                }
                                                else
                                                {
                                                    return Html::a($data->grupoItem->nome, ['grupoitens/view', 'id' => $data->grupoItem->id]);
                                                }
                                            }
                                        ],
                                    ],
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="alocacao" role="tabpanel" aria-labelledby="alocacao-tab">
                                <?= GridView::widget([
                                    'dataProvider' => new ArrayDataProvider([
                                        'allModels' => $utilizador->pedidosAlocacaoAsRequester
                                    ]),
                                    'layout'=> "{items}",
                                    'emptyText' => "Sem registos a mostrar.",
                                    'columns' => [
                                        [
                                            'label' => 'Nº Pedido',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                return Html::a($data->id, ['pedidoalocacao/view', 'id' => $data->id]);
                                            }
                                        ],
                                        'dataPedido',
                                        [
                                            'label' => 'Item',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                if($data->item_id != null)
                                                {
                                                    return Html::a($data->item->nome, ['item/view', 'id' => $data->item->id]);
                                                }
                                                else
                                                {
                                                    return Html::a($data->grupoItem->nome, ['grupoitens/view', 'id' => $data->grupoItem->id]);
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'status',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                return $data->getPrettyStatus();
                                            }
                                        ]
                                    ],
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="reparacao" role="tabpanel" aria-labelledby="reparacao-tab">
                                <?= GridView::widget([
                                    'dataProvider' => new ArrayDataProvider([
                                        'allModels' => $utilizador->pedidosReparacaoAsRequester
                                    ]),
                                    'layout'=> "{items}",
                                    'emptyText' => "Sem registos a mostrar.",
                                    'columns' => [
                                        [
                                            'label' => 'Nº Pedido',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                return Html::a($data->id, ['pedidoreparacao/view', 'id' => $data->id]);
                                            }
                                        ],
                                        'dataPedido',
                                        [
                                            'label' => 'status',
                                            'format' => 'html',
                                            'value' => function($data)
                                            {
                                                return $data->getPrettyStatus();
                                            }
                                        ]
                                    ],
                                ]); ?>
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