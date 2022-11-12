<?php

namespace backend\modules\api\controllers;

use common\models\Empresa;
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
                'status' => 'ok',
                'data' => [
                    'companyName' => $empresa->nome,
                    'companyNIF' => $empresa->NIF,
                ],
            ];
        }
        else
        {
            $data = [
                'status' => 'error',
                'message' => "Servidor não configurado",
            ];
        }
        return $this->asJson($data);
    }
}
