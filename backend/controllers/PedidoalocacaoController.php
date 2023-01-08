<?php

namespace backend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\Notificacoes;
use common\models\PedidoAlocacao;
use common\models\PedidoAlocacaoSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * PedidoAlocacaoController implements the CRUD actions for PedidoAlocacao model.
 */
class PedidoalocacaoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view'],
                            'allow' => true,
                            'roles' => ['readOthersPedidoAlocacao']
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['createPedidoAlocacao']
                        ],
                        [
                            'actions' => ['update', 'return'],
                            'allow' => true,
                            'roles' => ['changeStatusPedidoAlocacao']
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'negate' => ['post'],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all PedidoAlocacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PedidoAlocacaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PedidoAlocacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PedidoAlocacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PedidoAlocacao();
        // Por padrão, o utilizador ao qual o item vai ser associado, é ao utilizador que está a fazer o pedido
        $model->requerente_id = Yii::$app->user->id;

        $customTableData = null;
        $selectedItem = "";

        if ($this->request->isPost) {
            if($this->request->post('radioButtonSelection') != null)
            {
                //Obter dados que vieram da selecção de objeto

                $selectedItem = $this->request->post('radioButtonSelection');
                list($modelName, $id) = explode("_", $this->request->post('radioButtonSelection'));

                switch($modelName)
                {
                    case "Item":
                        $inner_model = Item::findOne($id);
                        $customTableData = new CustomTableRow($id, $inner_model->nome, $inner_model->serialNumber);
                        break;

                    case "Grupoitens":
                        $inner_model = Grupoitens::findOne($id);
                        $customTableData = new CustomTableRow($id, $inner_model->nome, $inner_model->listItensHumanReadable(100));
                        break;
                }

            }
            else
            {
                //Se é POST e não há uma seleção de radiobtn, é porque é para gravar o modelo

                $selectedItem = $this->request->post('selectedItem');
                if($selectedItem != "")
                {
                    if ($model->load($this->request->post())) {

                        list($inner_model, $id) = explode('_', $selectedItem);

                        switch($inner_model)
                        {
                            case "Item":
                                $model->item_id = $id;
                                if($model->item->isInActivePedidoAlocacao())
                                {
                                    // Esta verificação não é própriamente necessária, mas pode ficar aqui para proteção adicional
                                    $model->addError('item_id', 'Item selecionado já se encontra em uso.');
                                }
                                break;

                            case "Grupoitens":
                                $model->grupoItem_id = $id;
                                if($model->grupoItem->isinActivePedidoAlocacao())
                                {
                                    // Esta verificação não é própriamente necessária, mas pode ficar aqui para proteção adicional
                                    $model->addError('grupoItem_id', 'Item selecionado já se encontra em uso.');
                                }
                                break;

                            default:
                                throw new ServerErrorHttpException();
                        }

                        if($model->validate())
                        {
                            $model->status = PedidoAlocacao::STATUS_APROVADO;
                            $model->aprovador_id = Yii::$app->user->id;
                            $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");

                            if($model->save()) {
                                $model->cancelarPedidosAlocacaoAbertos();

                                Notificacoes::addNotification(
                                    $model->requerente_id,
                                    'O objeto "' . $model->getObjectName() . '" foi-lhe atribuído.',
                                    Url::to(['pedidoalocacao/view', 'id' => $model->id])
                                );

                                return $this->redirect(['view', 'id' => $model->id]);
                            }
                        }
                    }
                }
                else
                {
                    $model->addError('item_id', 'Selecione um objeto.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'customTableData' => $customTableData,
            'selectedItem' => $selectedItem,
        ]);
    }

    /**
     * Esta ação é utilizada para aprovar/negar um pedido
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->aprovador_id = Yii::$app->user->id;
            $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");
            if($model->save())
            {

                $message = null;

                if($model->status == PedidoAlocacao::STATUS_APROVADO)
                {
                    $message = "O seu pedido por " . $model->getObjectName() . " foi aprovado.";
                }
                else
                {
                    $message = "O seu pedido por " . $model->getObjectName() . " foi negado.";
                }

                Notificacoes::addNotification(
                    $model->requerente_id,
                    $message,
                    Url::to(['pedidoalocacao/view', 'id' => $model->id])
                );
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionReturn($id)
    {
        $model = $this->findModel($id);

        if($model->item xor $model->grupoItem)
        {
            $canProceed = true;

            if($model->item != null)
            {
                $canProceed = !$model->item->isInActivePedidoReparacao();
            }else
            {
                $canProceed = !$model->grupoItem->isInActivePedidoReparacao();
            }


            if($canProceed)
            {
                $model->status = PedidoAlocacao::STATUS_DEVOLVIDO;
                $model->dataFim = date_format(date_create("now"), "Y-m-d H:i:s");
                if($model->save())
                {
                    Notificacoes::addNotification(
                        $model->requerente_id,
                        'O objeto ' . $model->getObjectName() . " foi marcado como devolvido.",
                        Url::to(['pedidoalocacao/view', 'id' => $model->id])
                    );
                }
            }
            else
            {
                Yii::$app->session->setFlash("error", "Objeto está associado a um pedido de reparação ativo e por isso não pode ser devolvido");
            }
        }

        return $this->redirect(['pedidoalocacao/view', 'id' => $id]);
    }

    /**
     * Finds the PedidoAlocacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PedidoAlocacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PedidoAlocacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
