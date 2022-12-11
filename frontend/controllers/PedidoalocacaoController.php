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
            if(!$item->isInActiveItemsGroup() && !$item->isInActivePedidoAlocacao())
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


                if($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
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
