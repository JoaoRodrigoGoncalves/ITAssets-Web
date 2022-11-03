<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;

class LoginController extends Controller
{
//    public $modelClass = 'common\models\LoginForm';

    private $format = 'json';

    public function actionIndex()
    {
        $json = ['a', 'b', 'c'];

        return $this->asJson($json);
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

    // Actions
    public function actionList()
    {
    }

    public function actionView()
    {
    }

    public function actionCreate()
    {
    }

    public function actionUpdate()
    {
    }

    public function actionDelete()
    {
    }

}
