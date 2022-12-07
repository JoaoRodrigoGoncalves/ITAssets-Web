<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grupositensitem".
 *
 * @property int $grupoItens_id
 * @property int $item_id
 *
 * @property Grupoitens $grupoItens
 * @property Item $item
 */
class GruposItens_Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupositensitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupoItens_id', 'item_id'], 'required'],
            [['grupoItens_id', 'item_id'], 'integer'],
            [['grupoItens_id', 'item_id'], 'unique', 'targetAttribute' => ['grupoItens_id', 'item_id']],
            [['grupoItens_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupoitens::class, 'targetAttribute' => ['grupoItens_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'grupoItens_id' => 'Grupo Itens ID',
            'item_id' => 'Item',
        ];
    }

    /**
     * Gets query for [[GrupoItens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoItens()
    {
        return $this->hasOne(Grupoitens::class, ['id' => 'grupoItens_id']);
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


}
