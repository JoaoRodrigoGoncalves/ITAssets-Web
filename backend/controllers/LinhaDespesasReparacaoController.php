<?php

namespace backend\controllers;

use common\models\LinhaDespesasReparacao;
use common\models\PedidoReparacao;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhaDespesasReparacaoController implements the CRUD actions for LinhaDespesasReparacao model.
 */
class LinhaDespesasReparacaoController extends Controller
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
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['addDespesasPedidoReparacao']
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
     * Creates a new LinhaDespesasReparacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idReparacao)
    {
        $pedidoReparacao = PedidoReparacao::findOne($idReparacao);
        if ($pedidoReparacao != null)
        {
            if(in_array($pedidoReparacao->status, [PedidoReparacao::STATUS_EM_REVISAO, PedidoReparacao::STATUS_CONCLUIDO]))
            {
                $model = new LinhaDespesasReparacao();
                $model->pedidoReparacao_id = $idReparacao;

                if ($this->request->isPost) {
                    if ($model->load($this->request->post()) && $model->save()) {
                        return $this->redirect(['pedidoreparacao/view', 'id' => $idReparacao]);
                    }
                } else {
                    $model->loadDefaultValues();
                }

                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        throw new NotFoundHttpException("Pedido de Reparação Inválido");
    }

    /**
     * Updates an existing LinhaDespesasReparacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idLinha ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idLinha)
    {
        $model = $this->findModel($idLinha);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LinhaDespesasReparacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idLinha ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idLinha)
    {
        $this->findModel($idLinha)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LinhaDespesasReparacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaDespesasReparacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LinhaDespesasReparacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
