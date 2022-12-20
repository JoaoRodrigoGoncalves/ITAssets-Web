<?php

namespace backend\controllers;

use common\models\ObjectSelect;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ObjectSelectController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(),
        [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'callback' => $_POST['Callback'],
            'multiselect' => $_POST['Multiselect'] ?? false,
            'currentlySelected' => $data['currentlySelected'] ?? null,
            'tableData' => ObjectSelect::getArrayProvider()
        ]);
    }
}
