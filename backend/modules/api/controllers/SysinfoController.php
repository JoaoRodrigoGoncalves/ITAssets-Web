<?php

namespace backend\modules\api\controllers;

use common\models\Empresa;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SysinfoController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $empresa = Empresa::findOne(['id' => 1]);
        if($empresa)
        {
            $data = [
                'status' => '200',
                'companyName' => $empresa->nome,
                'companyNIF' => $empresa->NIF,
            ];
        }
        else
        {
            Yii::$app->response->statusCode = 500;
            $data = [
                'status' => '500',
                'message' => "Servidor não configurado",
            ];
        }
        return $this->asJson($data);
    }
}
