<?php

namespace backend\controllers;

use backend\models\History;
use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use common\models\PedidoAlocacao;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GrupoitensController implements the CRUD actions for Grupoitens model.
 */
class GrupoitensController extends Controller
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
                            'roles' => ['readGrupoItens']
                        ],
                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['writeGrupoItens']
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Grupoitens models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Grupoitens::find()->where(['status'=>10]),

            'pagination' => [
                'pageSize' => 10
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Mostra detalhes de um grupo de itens
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $grupoitens = $this->findModel($id);
        return $this->render('view', [
            'model' => $grupoitens,
            'historyProvider' => (new History())->getGroupHistory($id)
        ]);
    }

    /**
     * Creates a new Grupoitens model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Grupoitens();

        /* Critétios para os itens que pode sem apresentados para adicionar a um grupo:

            1 - Não pode fazer parte de outro grupo
            2 - Não pode estar alocado a um utilizador
            3 - Pode ter sido alocado anteriormente ou estar num pedido pendente
                    Pode ter sido ABERTO, NEGADO, DEVOLVIDO, CANCELADO.
                    Não pode estar em APROVADO

        */

        $itens = array();
        foreach (Item::findAll(['status' => 10]) as $item) {
            if(!$item->isInActivePedidoAlocacao() && !$item->isInActiveItemsGroup())
                $itens[] = $item;
        }

        if ($this->request->isPost) {

            if ($model->load($this->request->post())){
                $values = $this->request->post();

                //verfica se as keys do itens vem null
                if ($values['GruposItens_Item']['item_id'] != null) {
                    // Agora que sabemos que foram selecionados itens, tentamos guardar os dados base do Grupo
                    if($model->save())
                    {
                        // Gravar e associar individualmente os itens ao grupo recém criado
                        for ($i = 0; $i < count($values['GruposItens_Item']['item_id']); $i++)
                        {
                            $grupoitensItem = new GruposItens_Item();
                            $grupoitensItem->grupoItens_id = $model->id;
                            $grupoitensItem->item_id = $values['GruposItens_Item']['item_id'][$i];
                            $grupoitensItem->save();
                        }
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'itens' => $itens,
        ]);
    }

    /**
     * Updates an existing Grupoitens model.
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
     * Deletes an existing Grupoitens model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Verificar se o grupo está alocado ou em reparação
        if ($model->isinActivePedidoAlocacao() || $model->isInActivePedidoReparacao())
        {
            Yii::$app->session->setFlash("error", "Não é possivel eliminar o grupo visto que o mesmo esta associado a um Pedido de Alocação ou Reparação ativo");
        }
        else
        {
            //caso nao exista pedidos de alocacao
            $model->status= Grupoitens::STATUS_DELETED;
            if($model->save())
            {

                PedidoAlocacao::findOne(['grupoItem_id' => $id])?->cancelarPedidosAlocacaoAbertos();
                Yii::$app->session->setFlash("success", "Grupo foi eliminado com sucesso");
            }
            else
            {
                Yii::$app->session->setFlash("error", "Ocurreu um erro e não foi possível remover o grupo.");
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Grupoitens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Grupoitens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grupoitens::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
