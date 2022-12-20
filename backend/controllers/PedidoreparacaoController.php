<?php

namespace backend\controllers;

use common\models\CustomTableRow;
use common\models\Grupoitens;
use common\models\Item;
use common\models\PedidoReparacao;
use common\models\PedidoReparacaoSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['createPedidoReparacao']
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['changeStatusPedidoAlocacao']
                        ],
                        [
                            'actions' => ['despesas'],
                            'allow' => true,
                            'roles' => ['addDespesasPedidoReparacao']
                        ]
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
        $searchModel = new PedidoReparacaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
            'model' => $this->findModel($id),
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
        $objectosSelecionados = null;

        // A key onde vêm os valores selecionados pelo utilizador no object-select é "selection"

        if(isset($_POST['selection']))
        {
            foreach ($_POST['selection'] as $item) {

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

//        if ($this->request->isPost) {
//            if()
//        }

        return $this->render('create', [
            'model' => $model,
            'objectosSelecionados' => $objectosSelecionados,
        ]);
    }

    /**
     * Updates an existing PedidoReparacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PedidoReparacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
