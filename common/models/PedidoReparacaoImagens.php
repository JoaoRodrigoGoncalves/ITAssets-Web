<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido_reparacao_imagens".
 *
 * @property int $id
 * @property string|null $caminho
 * @property int|null $pedidoReparacao_id
 *
 * @property PedidoReparacao $pedidoReparacao
 */
class PedidoReparacaoImagens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_reparacao_imagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pedidoReparacao_id'], 'integer'],
            [['caminho'], 'string', 'max' => 255],
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
            'caminho' => 'Caminho',
            'pedidoReparacao_id' => 'Pedido Reparacao ID',
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
