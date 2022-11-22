<?php

namespace backend\controllers;

use common\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
                        'actions' => ['index','create', 'update'],
                        'allow' => true,
                        'roles' => ['administrador']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Empresa models.
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $empresa = Empresa::findOne(['id' => 1]);

        if($empresa)
        {
            return $this->render('index', [
                'empresa' => $empresa,
            ]);
        }
        else
        {
            return $this->redirect(Url::to(['empresa/create']));
        }
    }

    /**
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if(Empresa::find()->orderBy(1)->count() == 0) {
            $model = new Empresa();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(Url::to(['empresa/index']));
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        return $this->redirect(Url::to(['empresa/index']));
    }

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivar()
    {
        $model = Empresa::findOne(['id' => 1]);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['empresa/index']));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
