<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PedidoAlocacao;

/**
 * PedidoAlocacaoSearch represents the model behind the search form of `common\models\PedidoAlocacao`.
 */
class PedidoAlocacaoSearch extends PedidoAlocacao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'requerente_id', 'aprovador_id'], 'integer'],
            [['dataPedido'], 'date', 'format' => 'php:Y-m-d'],
            [['dataPedido'], 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PedidoAlocacao::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Precisamos desta verificação porque horas são concatenadas à data indicada no filtro
        if($this->dataPedido != null)
        {
            $query->andFilterWhere([
                'id' => $this->id,
                'status' => $this->status,
                'requerente_id' => $this->requerente_id,
                'aprovador_id' => $this->aprovador_id
            ]);
            $query->andFilterWhere(['>=', 'dataPedido', $this->dataPedido . " 00:00:00"]);
            $query->andFilterWhere(['<=', 'dataPedido', $this->dataPedido . " 23:59:59"]);
        }
        else
        {
            $query->andFilterWhere([
                'id' => $this->id,
                'status' => $this->status,
                'requerente_id' => $this->requerente_id,
                'aprovador_id' => $this->aprovador_id,
            ]);
        }
        return $dataProvider;
    }
}
