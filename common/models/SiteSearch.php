<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Site;

/**
 * SiteSearch represents the model behind the search form of `common\models\Site`.
 */
class SiteSearch extends Site
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'safe'],
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
        $query = Site::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        /**
         * TODO: Adicionar filtro para poder pesquisar a morada inteira ou conseguir encontrar uma
         * morada independentemente se está exatamente igual ao registo
         */
         $query->andFilterWhere(['like', 'nome', $this->nome])
               ->orFilterWhere(['like', 'rua', $this->nome])
               ->orFilterWhere(['like', 'localidade', $this->nome])
               ->orFilterWhere(['like', 'codPostal', $this->nome]);

        return $dataProvider;
    }
}
