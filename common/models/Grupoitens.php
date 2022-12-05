<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grupoitens".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $notas
 * @property int|null $status
 *
 * @property GruposItens_Item[] $grupositensitems
 * @property Item[] $items
 * @property Item[] $items0
 * @property PedidoAlocacao[] $pedidoAlocacaos
 */
class Grupoitens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupoitens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['notas'], 'string'],
            [['status'], 'integer'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'notas' => 'Notas',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Grupositensitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupositensitems()
    {
        return $this->hasMany(GruposItens_Item::class, ['grupoItens_id' => 'id']);
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['grupoitens_id' => 'id']);
    }

    /**
     * Gets query for [[Items0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems0()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])->viaTable('grupositensitem', ['grupoItens_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoAlocacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoAlocacaos()
    {
        return $this->hasMany(PedidoAlocacao::class, ['grupoItem_id' => 'id']);
    }
}
