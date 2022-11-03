<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $NIF
 * @property string|null $rua
 * @property string|null $codigoPostal
 * @property string|null $localidade
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'rua', 'localidade'], 'string', 'max' => 255],
            [['NIF'], 'string', 'max' => 9],
            [['codigoPostal'], 'string', 'max' => 8],
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
            'NIF' => 'Nif',
            'rua' => 'Rua',
            'codigoPostal' => 'Codigo Postal',
            'localidade' => 'Localidade',
        ];
    }
}
