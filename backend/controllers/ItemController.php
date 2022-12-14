<?php

namespace backend\controllers;

use backend\models\History;
use common\models\Item;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['readItem']
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['writeItem']
                    ]
                ],
            ],
        ];

    }

    /**
     * Lists all Item models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $itens= Item::find()->where(['status' => Item::STATUS_ACTIVE])->all();

        return $this->render('index',['itens'=>$itens]);
    }

    /**
     * Displays a single Item model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'item' => $this->findModel($id),
            'historyProvider' => (new History())->getItemHistory($id),
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $item = new Item();

        if ($this->request->isPost) {
            $item->load($this->request->post());
            $item->status = 10;
            if($item->save()) {
                return $this->redirect(['view', 'id' => $item->id]);
            }
        } else {
            $item->loadDefaultValues();
        }

        return $this->render('create', [
            'item' => $item,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $item = $this->findModel($id);

        if ($this->request->isPost && $item->load($this->request->post()) && $item->save()) {
            return $this->redirect(Url::to(['item/index']));
        }

        return $this->render('update', [
            'item' => $item,
        ]);
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $item = Item::findOne($id);
        if(!$item->isInActivePedidoAlocacao())
        {
            $item->status = 0;
            $item->save();
        }
        else
        {
            Yii::$app->session->setFlash('error', 'Não é possível remover o item porque este se encontra alocado a um utilizador');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}