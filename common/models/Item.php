<?php

namespace common\models;

use Yii;
use function PHPUnit\Framework\stringContains;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $serialNumber
 * @property string|null $notas
 */
class Item extends \yii\db\ActiveRecord
{
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
        return  [
            [['nome','serialNumber','notas'],'string', 'max'=>255],
            [['nome', 'serialNumber'], 'required', 'message' => 'Campo Obrigatório'], // Campos obrigatórios
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
            'serialNumber' => 'Serial Number',
            'notas' => 'Notas',
        ];
    }
}
