<?php

namespace backend\controllers;

use common\models\Empresa;
use common\models\LinhaDespesasReparacao;
use common\models\PedidoReparacao;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ErrorAction;

class DashboardController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['administrador', 'operadorLogistica']
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        if(Empresa::find()->count() == 0)
        {
            return $this->redirect(Url::to(['empresa/create']));
        }

        $reparacoes = PedidoReparacao::find()->filterWhere(['>=', 'dataPedido', strtotime('-5 days')])->all();

        $dadosGrafico = array();

        for ($i = 4; $i >= 0; $i--)
        {
            //Gerar os indexes para cada dia. Fazemos de 4 para 0 de forma a incluir o dia atual
            $dadosGrafico[date("d/m/Y", strtotime("-" . $i . " days"))] = 0;
        }

        $totalDespesas = 0;

        foreach ($reparacoes as $reparacao) {
            $data = date("d/m/Y", strtotime($reparacao->dataPedido));
            if(isset($dadosGrafico[$data]))
            {
                // Como a $reparacoes está a devolver um ActiveRecord[] e não um PedidoReparacao[], não
                // é possível aceder à associação das linhas de reparação diretamente
                foreach (LinhaDespesasReparacao::findAll(['pedidoReparacao_id' => $reparacao->id]) as $despesas) {
                    $dadosGrafico[$data] += $despesas->preco * $despesas->quantidade;
                    $totalDespesas += $despesas->preco * $despesas->quantidade;
                }
            }
        }

        $this->layout = 'main';
        return $this->render('index', [
            'dadosGrafico' => $dadosGrafico,
            'totalDespesas' => $totalDespesas,
        ]);
    }
}