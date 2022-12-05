<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $rua
 * @property string|null $localidade
 * @property string|null $codPostal
 * @property string|null $coordenadas
 * @property string|null $notas
 *
 * @property Item[] $items
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['notas'], 'string'],
            [['nome', 'rua', 'localidade', 'coordenadas'], 'string', 'max' => 255],
            [['codPostal'], 'string', 'max' => 8],
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
            'rua' => 'Rua',
            'localidade' => 'Localidade',
            'codPostal' => 'Código Postal',
            'coordenadas' => 'Coordenadas',
            'notas' => 'Notas',
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['site_id' => 'id']);
    }
}
