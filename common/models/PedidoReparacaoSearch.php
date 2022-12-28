<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PedidoReparacao;

/**
 * PedidoReparacaoSearch represents the model behind the search form of `common\models\PedidoReparacao`.
 */
class PedidoReparacaoSearch extends PedidoReparacao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'requerente_id', 'responsavel_id', 'status'], 'integer'],
            [['dataPedido', 'dataInicio', 'dataFim', 'descricaoProblema', 'respostaObs'], 'safe'],
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
        $query = PedidoReparacao::find();

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
            'dataPedido' => $this->dataPedido,
            'dataInicio' => $this->dataInicio,
            'dataFim' => $this->dataFim,
            'requerente_id' => $this->requerente_id,
            'responsavel_id' => $this->responsavel_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'descricaoProblema', $this->descricaoProblema])
            ->andFilterWhere(['like', 'respostaObs', $this->respostaObs]);

        return $dataProvider;
    }
}
