<?php

namespace backend\controllers;

use common\models\Empresa;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

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
                        // Não separamos as ações e permissões porque estas páginas só devem
                        // ser vistas por quem tem permissões para criar/editar os dados da
                        // empresa
                        'actions' => ['index','create', 'update'],
                        'allow' => true,
                        'roles' => ['writeEmpresa']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Empresa models.
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        $empresa = Empresa::find()->limit(1)->one();

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
     * @return string|Response
     */
    public function actionCreate()
    {
        if(Empresa::find()->count() == 0) {
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
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = Empresa::find()->limit(1)->one();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['empresa/index']));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
