<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_despesas_reparacao".
 *
 * @property int $id
 * @property string|null $descricao
 * @property float|null $quantidade
 * @property float|null $preco
 * @property int|null $pedidoReparacao_id
 *
 * @property PedidoReparacao $pedidoReparacao
 */
class LinhaDespesasReparacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_despesas_reparacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'preco'], 'number'],
            [['pedidoReparacao_id'], 'integer'],
            [['descricao'], 'string', 'max' => 255],
            [['descricao', 'preco', 'quantidade', 'pedidoReparacao_id'], 'required'],
            [['pedidoReparacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => PedidoReparacao::class, 'targetAttribute' => ['pedidoReparacao_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'quantidade' => 'Quantidade',
            'preco' => 'Preço Unitário',
            'pedidoReparacao_id' => 'Pedido Reparação',
        ];
    }

    /**
     * Gets query for [[PedidoReparacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoReparacao()
    {
        return $this->hasOne(PedidoReparacao::class, ['id' => 'pedidoReparacao_id']);
    }
}
