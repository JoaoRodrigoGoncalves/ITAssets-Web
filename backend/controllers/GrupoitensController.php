<?php

namespace backend\controllers;

use common\models\Grupoitens;
use common\models\GruposItens_Item;
use common\models\Item;
use common\models\PedidoAlocacao;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\isNull;

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
     * Displays a single Grupoitens model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $grupoitens=$this->findModel($id);

        //$grupoitens->items0= vai buscar todos os itens associados a um grupo

        $itens=$grupoitens->items0;


        return $this->render('view', [
            'model' => $grupoitens,
            'itens' => $itens

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
        $model_item = new GruposItens_Item();

        $itens=Item::find()
            ->leftJoin('grupositensitem','grupositensitem.item_id = item.id')
            ->leftJoin('grupoitens','grupoitens.id=grupositensitem.grupoItens_id')
            ->where('grupoitens.status = 9 or grupositensitem.item_id IS NULL')
            ->all();



        if ($this->request->isPost) {


            if ($model->load($this->request->post()) && $model->save()){
                $values=$this->request->post();

                //verfica se as keys do itens vem null

                //corre quantos valores tiverem
                if ($values['GruposItens_Item']['item_id'] != null) {
                    for ($i=0;$i<count($values['GruposItens_Item']['item_id']);$i++)
                    {
                        $grupoitensItem= new GruposItens_Item();
                       $grupoitensItem->grupoItens_id=$model->id;
                       $grupoitensItem->item_id=$values['GruposItens_Item']['item_id'][$i];
                       $grupoitensItem->save();

                    }
                }
                return $this->redirect(['index', 'id' => $model->id]);

            }

        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'itens'=>$itens,
            'model_item'=>$model_item,
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

        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $pedidos_alocacao= PedidoAlocacao::find()->where(['grupoItem_id'=>$id])->andWhere('dataFim IS NULL')->all();

        if (!empty($pedidos_alocacao))
        {
            //caso o exista pedidos de alocacao
            Yii::$app->session->setFlash("error", "Não e possivel eliminar o grupo visto que o mesmo esta associado a um Pedido");
        }
        else
        {
            Yii::$app->session->setFlash("success", "Grupo foi eliminado com sucesso");
            //caso nao exista pedidos de alocacao
            $model->status=9;
            $model->save();

        }


        return $this->redirect(['index']);
    }


    public function actiondeleteitem($id)
    {


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
