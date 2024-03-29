<?php

namespace frontend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\PedidoAlocacao;
use common\models\PedidoAlocacaoSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
                            'actions' => ['index', 'view', 'create'],
                            'allow' => true,
                            'roles' => ['createPedidoAlocacao']
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['editPedidoAlocacao']
                        ],
                        [
                            'actions' => ['cancel'],
                            'allow' => true,
                            'roles' => ['cancelPedidoAlocacao']
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'cancel' => ['post'],
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
        $pedidos = PedidoAlocacao::find()
            ->where(['requerente_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'pedidos' => $pedidos,
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
        $modelo = $this->findModel($id);

        if($modelo->requerente_id == Yii::$app->user->id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else
        {
            throw new UnauthorizedHttpException();
        }
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

                        if($model->save()) {
                            return $this->redirect(['view', 'id' => $model->id]);
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
     * Cancela um Pedido de Alocação
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCancel($id)
    {
        $model = $this->findModel($id);

        if($model->requerente_id == Yii::$app->user->id)
        {
            $model->status = PedidoAlocacao::STATUS_CANCELADO;
            $model->dataInicio = date_format(date_create(), "Y-m-d H:i:s");
            $model->save();
            return $this->redirect(['index']);
        }
        else
        {
            throw new UnauthorizedHttpException();
        }
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
