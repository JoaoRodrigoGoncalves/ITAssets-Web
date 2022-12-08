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
            [['dataPedido'], 'safe'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'dataPedido' => $this->dataPedido,
            'requerente_id' => $this->requerente_id,
            'aprovador_id' => $this->aprovador_id,
        ]);

        //TODO: Arranjar filtro por data

        return $dataProvider;
    }
}
