<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido_alocacao".
 *
 * @property int $id
 * @property int $status
 * @property int|null $item_id
 * @property int|null $grupoItem_id
 * @property string $dataInicio
 * @property string|null $dataFim
 * @property string|null $obs
 * @property string|null $obsResposta
 * @property int $requerente_id
 * @property int|null $aprovador_id
 *
 * @property User $aprovador
 * @property Grupoitens $grupoItem
 * @property Item $item
 * @property User $requerente
 */
class PedidoAlocacao extends \yii\db\ActiveRecord
{

    const STATUS_ABERTO = 10;
    const STATUS_APROVADO = 9;
    const STATUS_NEGADO = 8;
    const STATUS_CANCELADO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_alocacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'item_id', 'grupoItem_id', 'requerente_id', 'aprovador_id'], 'integer'],
            [['dataInicio', 'dataFim'], 'safe'],
            [['obs', 'obsResposta'], 'string'],
            [['requerente_id'], 'required'],
            [['aprovador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['aprovador_id' => 'id']],
            [['grupoItem_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupoitens::class, 'targetAttribute' => ['grupoItem_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'id']],
            [['requerente_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['requerente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'item_id' => 'Item ID',
            'grupoItem_id' => 'Grupo Item ID',
            'dataInicio' => 'Data Inicio',
            'dataFim' => 'Data Fim',
            'obs' => 'Obs',
            'obsResposta' => 'Obs Resposta',
            'requerente_id' => 'Requerente ID',
            'aprovador_id' => 'Aprovador ID',
        ];
    }

    /**
     * Gets query for [[Aprovador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAprovador()
    {
        return $this->hasOne(User::class, ['id' => 'aprovador_id']);
    }

    /**
     * Gets query for [[GrupoItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoItem()
    {
        return $this->hasOne(Grupoitens::class, ['id' => 'grupoItem_id']);
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
     * Gets query for [[Requerente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequerente()
    {
        return $this->hasOne(User::class, ['id' => 'requerente_id']);
    }
}
