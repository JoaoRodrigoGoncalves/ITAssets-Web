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
        $config = json_decode($_POST['config']);

        return $this->render('index', [
            'callback' => $config->Callback,
            'multiselect' => $config->Multiselect ?? false,
//            'currentlySelected' => $data['currentlySelected'] ?? null,
            'tableData' => ObjectSelect::getArrayProvider($config)
        ]);
    }
}
