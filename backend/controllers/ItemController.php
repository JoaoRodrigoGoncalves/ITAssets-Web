<?php

namespace backend\controllers;

use common\models\Item;
use common\models\Categoria;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                        'actions' => ['index','create', 'view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['administrador', 'operadorLogistico']
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];

    }

    /**
     * Lists all Item models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categoria = Categoria::find()->all();

        if ($categoria != null)
        {
            $itens= Item::find()
                ->where(['status' => 10])
                ->all();;

            return $this->render('index',['itens'=>$itens]);
        }
        else
        {
            Yii::$app->session->setFlash('success', 'Tens de criar primeiro categoria');
            return $this->redirect(['categoria/create']);
        }
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
        ]);
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $categoria = Categoria::find()->all();
        if ($categoria != null) {
            $item = new Item();

            if ($this->request->isPost) {
                $item->load($this->request->post());
                $item->status=10;
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
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
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
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $item=Item::findOne($id);
        $item->status=0;
        $item->save();
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