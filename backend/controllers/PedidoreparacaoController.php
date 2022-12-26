<?php

namespace backend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\LinhaDespesasReparacao;
use common\models\LinhaPedidoReparacao;
use common\models\PedidoAlocacao;
use common\models\PedidoReparacao;
use common\models\PedidoReparacaoSearch;
use common\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii\web\ServerErrorHttpException;

/**
 * PedidoReparacaoController implements the CRUD actions for PedidoReparacao model.
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
                            'actions' => ['index', 'view'],
                            'allow' => true,
                            'roles' => ['readOthersPedidoReparacao']
                        ],
                        [
                            'actions' => ['create', 'linhas'],
                            'allow' => true,
                            'roles' => ['createPedidoReparacao']
                        ],
                        [
                            'actions' => ['selfassign', 'finalizar'],
                            'allow' => true,
                            'roles' => ['changeStatusPedidoAlocacao']
                        ],
                        [
                            'actions' => ['despesas'],
                            'allow' => true,
                            'roles' => ['addDespesasPedidoReparacao']
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
                        'linhas' => ['GET', 'POST'],
                    ],
                ]
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
        $searchModel = new PedidoReparacaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new PedidoReparacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PedidoReparacao();
        // Por padrão, o utilizador ao qual o item vai ser associado, é ao utilizador que está a fazer o pedido
        $model->requerente_id = Yii::$app->user->id;

        if($this->request->isPost && $model->load($this->request->post()))
        {
            $requerente = User::findOne($model->requerente_id);

            // Verificar se o utilizador tem algum item associado
            if($requerente->getPedidosAlocacaoAsRequester()->where(['status' => PedidoAlocacao::STATUS_APROVADO])->count() > 0)
            {
                if($model->save())
                {
                    return $this->redirect(['pedidoreparacao/linhas', 'id' => $model->id]);
                }
            }
            else
            {
                $model->addError('requerente_id', "Utilizador selecionado não tem qualquer item associado e por isso não é possível registar um pedido de reparação em seu nome.");
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSelfassign($id)
    {
        $model = $this->findModel($id);
        if($model->status == PedidoReparacao::STATUS_ABERTO)
        {
            $model->responsavel_id = Yii::$app->user->id;
            $model->status = PedidoReparacao::STATUS_EM_REVISAO;
            $model->save();
        }
        else
        {
            Yii::$app->session->setFlash("error", "Não é possível atribuir um responsável neste estado.");
        }
        return $this->redirect(['pedidoreparacao/view', 'id' => $model->id]);
    }

    public function actionLinhas($id)
    {
        $model = $this->findModel($id);

        $objectosSelecionados = null;
        $objectosSelecionados_string = "";

        if(isset($_POST['selection']))
        {
            foreach ($_POST['selection'] as $objecto) {

                $objectosSelecionados_string .= $objecto . ","; // Adicionar os itens a uma string para que depois possam ser guardados

                list($modelName, $id) = explode("_", $objecto);

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
                'allModels' => $objectosSelecionados
            ]);
        }

        if(isset($_POST['selectedObjects']))
        {
            $objects = explode(",", $_POST['selectedObjects']);

            if(sizeof($objects) > 0)
            {
                if($model->save())
                {
                    foreach ($objects as $objeto) {
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

                        // Trocar o status do default de STATUS_EM_PREPARACAO para STATUS_EM_REVISAO visto que isto é uma ação administrativa
                        $model->status = PedidoReparacao::STATUS_EM_REVISAO;
                        $model->responsavel_id = Yii::$app->user->id;
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


        return $this->render('linhas', [
            'model' => $model,
            'objectosSelecionados' => $objectosSelecionados,
            'objectosSelecionados_string' => substr($objectosSelecionados_string, 0, -1),
        ]);
    }

    public function actionFinalizar($id)
    {
        $model = $this->findModel($id);
        if(in_array($model->status, [PedidoReparacao::STATUS_EM_PREPARACAO, PedidoReparacao::STATUS_EM_REVISAO]))
        {
            if ($this->request->isPost && $model->load($this->request->post())) {

                $model->status = PedidoReparacao::STATUS_CONCLUIDO;
                if($model->save())
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('finalizar', [
                'model' => $model
            ]);
        }
    }

    public function actionCancelar($id)
    {
        $model = $this->findModel($id);
        if($model->status == PedidoReparacao::STATUS_EM_PREPARACAO)
        {
            $model->status = PedidoReparacao::STATUS_CANCELADO;
            $model->save();
        }
        else
        {
            Yii::$app->session->setFlash("error", "Não é possível cancelar este pedido");
        }
        return $this->redirect(['view', 'id' => $model->id]);
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
