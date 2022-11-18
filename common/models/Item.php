<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $serialNumber
 * @property int|null $categoria_id
 * @property string|null $notas
 * @property int|null $status
 *
 * @property Categoria $categoria
 */
class Item extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_id', 'status'], 'integer'],
            [['nome', 'serialNumber', 'notas'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
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
            'serialNumber' => 'Número de Série',
            'categoria_id' => 'Categoria',
            'notas' => 'Notas',
            'status' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    public function getStatusLabel()
    {
        switch ($this->status)
        {
            case self::STATUS_ACTIVE:
                return 'Ativo';

            case self::STATUS_DELETED:
                return 'Removido';

            default:
                return $this->status;
        }
    }
}
