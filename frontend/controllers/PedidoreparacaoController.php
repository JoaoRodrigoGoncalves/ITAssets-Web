<?php

namespace frontend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\LinhaPedidoReparacao;
use common\models\PedidoReparacao;
use frontend\models\PedidoReparacaoSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * PedidoreparacaoController implements the CRUD actions for PedidoReparacao model.
 */
class PedidoreparacaoController extends Controller
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
                            'roles' => ['createPedidoReparacao']
                        ],
                        [
                            'actions' => ['cancelar'],
                            'allow' => true,
                            'roles' => ['cancelPedidoReparacao']
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'cancelar' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all PedidoReparacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $reparacoes = PedidoReparacao::find()
            ->where(['requerente_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'reparacoes' => $reparacoes,
        ]);
    }

    /**
     * Displays a single PedidoReparacao model.
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
     * Creates a new PedidoReparacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PedidoReparacao();
        $model->requerente_id = Yii::$app->user->id;
        $objectosSelecionados = null;
        $objectosSelecionados_string = ""; //Sim, isto é para ser vazio

        if(isset($_POST['selection']))
        {
            // A key onde vêm os valores selecionados pelo utilizador no object-select é "selection"
            foreach ($_POST['selection'] as $item) {

                $objectosSelecionados_string .= $item . ","; // Adicionar os itens a uma string para que depois possam ser guardados

                list($modelName, $id) = explode("_", $item);

                switch($modelName)
                {
                    case "Item":
                        $inner_model = Item::findOne($id);
                        $objectosSelecionados[] = new CustomTableRow($id, $inner_model->nome, $inner_model->serialNumber);
                        break;

                    case "Grupoitens":
                        $inner_model = Grupoitens::findOne($id);
                        $objectosSelecionados[] = new CustomTableRow($id, $inner_model->nome, null);
                        break;
                }
            }

            $objectosSelecionados = new ArrayDataProvider([
                'allModels' => $objectosSelecionados,
            ]);
        }

        if($this->request->isPost && $model->load($this->request->post()))
        {
            if($model->descricaoProblema != null)
            {
                $objetos = explode(",", $_POST['objectosSelecionados_string']);

                if(sizeof($objetos) > 0)
                {
                    if($model->save())
                    {
                        foreach ($objetos as $objeto) {
                            $linhaReparacao = new LinhaPedidoReparacao();
                            $linhaReparacao->pedido_id = $model->id;

                            list($modelName, $id) = explode("_", $objeto);

                            switch($modelName)
                            {
                                case "Item":
                                    $linhaReparacao->item_id = $id;
                                    break;

                                case "Grupoitens":
                                    $linhaReparacao->grupo_id = $id;
                                    break;

                                default:
                                    throw new ServerErrorHttpException();
                            }
                            $linhaReparacao->save();

                            // Trocar o status do default de STATUS_EM_PREPARACAO para STATUS_ABERTO;
                            $model->status = PedidoReparacao::STATUS_ABERTO;
                            $model->save();
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', 'Ocoreu um erro ao guardar o pedido de reparação.');
                    }
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'É necessário indicar pelo menos um objeto!');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'objectosSelecionados' => $objectosSelecionados,
            'objectosSelecionados_string' => substr($objectosSelecionados_string, 0, -1),
        ]);
    }

    /**
     * Deletes an existing PedidoReparacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCancelar($id)
    {
        $model = $this->findModel($id);

        if($model->requerente_id == Yii::$app->user->id && $model->status == PedidoReparacao::STATUS_ABERTO)
        {
            $model->status = PedidoReparacao::STATUS_CANCELADO;
            $model->dataFim = date_format(date_create(), "Y-m-d H:i:s");
            $model->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PedidoReparacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PedidoReparacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PedidoReparacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
