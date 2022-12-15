<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido_reparacao".
 *
 * @property int $id
 * @property string $dataPedido
 * @property string|null $dataInicio
 * @property string|null $dataFim
 * @property string $descricaoProblema
 * @property int $status
 * @property string|null $respostaObs
 *
 * @property LinhaDespesasReparacao[] $linhasDespesasReparacao
 * @property LinhaPedidoReparacao[] $linhasPedidoReparacao
 * @property PedidoReparacaoImagens[] $pedidosReparacaoImagens
 */
class PedidoReparacao extends \yii\db\ActiveRecord
{
    const STATUS_ABERTO = 10;
    const STATUS_EM_PROCESSAMENTO = 9;
    const STATUS_TERMINADO = 3;
    const STATUS_CANCELADO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_reparacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataPedido', 'dataInicio', 'dataFim'], 'safe'],
            [['descricaoProblema'], 'required'],
            [['descricaoProblema', 'respostaObs'], 'string'],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dataPedido' => 'Data Pedido',
            'dataInicio' => 'Data Inicio',
            'dataFim' => 'Data Fim',
            'descricaoProblema' => 'Descricao Problema',
            'status' => 'Status',
            'respostaObs' => 'Resposta Obs',
        ];
    }

    /**
     * Gets query for [[LinhaDespesasReparacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasDespesaReparacao()
    {
        return $this->hasMany(LinhaDespesasReparacao::class, ['pedidoReparacao_id' => 'id']);
    }

    /**
     * Gets query for [[LinhaPedidoReparacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasPedidoReparacao()
    {
        return $this->hasMany(LinhaPedidoReparacao::class, ['pedido_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoReparacaoImagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidosReparacaoImagens()
    {
        return $this->hasMany(PedidoReparacaoImagens::class, ['pedidoReparacao_id' => 'id']);
    }
}
