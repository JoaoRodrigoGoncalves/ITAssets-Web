<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linha_pedido_reparacao".
 *
 * @property int $id
 * @property string|null $obs
 * @property int $pedido_id
 * @property int|null $item_id
 * @property int|null $grupo_id
 *
 * @property Grupoitens $grupo
 * @property Item $item
 * @property PedidoReparacao $pedido
 */
class LinhaPedidoReparacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linha_pedido_reparacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['obs'], 'string'],
            [['pedido_id'], 'required'],
            [['pedido_id', 'item_id', 'grupo_id'], 'integer'],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => PedidoReparacao::class, 'targetAttribute' => ['pedido_id' => 'id']],
            [['grupo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupoitens::class, 'targetAttribute' => ['grupo_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obs' => 'Obs',
            'pedido_id' => 'Pedido ID',
            'item_id' => 'Item ID',
            'grupo_id' => 'Grupo ID',
        ];
    }

    /**
     * Gets query for [[Grupo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupoitens::class, ['id' => 'grupo_id']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    /**
     * Gets query for [[Pedido]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(PedidoReparacao::class, ['id' => 'pedido_id']);
    }
}
