<?php

namespace backend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\PedidoAlocacao;
use common\models\PedidoAlocacaoSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
                            'roles' => ['editPedidoAlocacao']
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
        $itens = Item::findAll(['status' => Item::STATUS_ACTIVE]);
        $grupos = Grupoitens::findAll(['status' => Grupoitens::STATUS_ACTIVE]);

        /**
         * --- CustomID ('I_'/'G_' + id
         *  |- Nome
         *  |- Serial
         */

        $customTableData = array();

        foreach ($itens as $item)
        {
            if($item->grupoItens == null && !$item->isInActivePedidoAlocacao())
            {
                $row = new CustomTableRow("I_" . $item->id, $item->nome, $item->serialNumber);
                $customTableData[] = $row;
            }
        }

        foreach ($grupos as $grupo)
        {
            if(!$grupo->isinActivePedidoAlocacao())
            {
                $row = new CustomTableRow("G_" . $grupo->id, $grupo->nome, null);
                $customTableData[] = $row;
            }
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $row = $this->request->post()['item'];
                $row_data = explode('_', $row);

                switch($row_data[0])
                {
                    case "I":
                        $model->item_id = $row_data[1];
                        if($model->item->isInActivePedidoAlocacao())
                        {
                            $model->addError('item_id', 'Item selecionado já se encontra em uso.');
                        }
                        break;

                    case "G":
                        $model->grupoItem_id = $row_data[1];
                        if($model->grupoItem->isinActivePedidoAlocacao())
                        {
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
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    else
                    {
                        dd($model->errors);
                    }
                }
                else
                {
                    dd($model->errors);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'customTableData' => $customTableData,
        ]);
    }

    /**
     * Updates an existing PedidoAlocacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->aprovador_id = Yii::$app->user->id;
            $model->save();
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
            $model->status = PedidoAlocacao::STATUS_DEVOLVIDO;
            $model->dataFim = date_format(date_create("now"), "Y-m-d h:i:s");
            $model->save();
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
