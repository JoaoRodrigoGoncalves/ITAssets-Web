<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido_reparacao".
 *
 * @property int $id
 * @property string $dataPedido
 * @property string|null $dataInicio
 * @property string|null $dataFim
 * @property string $descricaoProblema
 * @property int $requerente_id
 * @property int|null $responsavel_id
 * @property int $status
 * @property string|null $respostaObs
 *
 * @property LinhaDespesasReparacao[] $linhasDespesasReparacao
 * @property LinhaPedidoReparacao[] $linhasPedidoReparacao
 * @property PedidoReparacaoImagens[] $pedidoReparacaoImagens
 * @property User $requerente
 * @property User $responsavel
 */
class PedidoReparacao extends \yii\db\ActiveRecord
{

    const STATUS_EM_PREPARACAO = 10; // Ainda não está aberto. Está começado mas não acabado. Blame backoffice
    const STATUS_ABERTO = 8;
    const STATUS_EM_REVISAO = 6;
    const STATUS_CONCLUIDO = 4;
    const STATUS_CANCELADO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_reparacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataPedido', 'dataInicio', 'dataFim'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['descricaoProblema', 'requerente_id'], 'required'],
            [['descricaoProblema', 'respostaObs'], 'string'],
            [['requerente_id', 'responsavel_id', 'status'], 'integer'],
            [['dataInicio', 'dataFim', 'respostaObs', 'responsavel_id'], 'default', 'value' => null],
            [['requerente_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['requerente_id' => 'id']],
            [['responsavel_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['responsavel_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dataPedido' => 'Data Pedido',
            'dataInicio' => 'Data Inicio',
            'dataFim' => 'Data Fim',
            'descricaoProblema' => 'Descricao Problema',
            'requerente_id' => 'Relator',
            'responsavel_id' => 'Responsável',
            'status' => 'Estado',
            'respostaObs' => 'Detalhes da Reparação',
        ];
    }

    /**
     * Gets query for [[LinhasDespesasReparacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasDespesasReparacao()
    {
        return $this->hasMany(LinhaDespesasReparacao::class, ['pedidoReparacao_id' => 'id']);
    }

    /**
     * Gets query for [[LinhasPedidoReparacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasPedidoReparacao()
    {
        return $this->hasMany(LinhaPedidoReparacao::class, ['pedido_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoReparacaoImagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoReparacaoImagens()
    {
        return $this->hasMany(PedidoReparacaoImagens::class, ['pedidoReparacao_id' => 'id']);
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

    /**
     * Gets query for [[Responsavel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavel()
    {
        return $this->hasOne(User::class, ['id' => 'responsavel_id']);
    }

    public function getPrettyStatus()
    {
        switch($this->status)
        {
            case self::STATUS_EM_PREPARACAO:
                return "<span class='badge badge-warning text-white'>Em Preparação</span>";

                break;

            case self::STATUS_ABERTO:
                return "<span class='badge badge-primary'>Aberto</span>";
                break;

            case self::STATUS_EM_REVISAO:
                return "<span class='badge badge-success'>Em Revisão</span>";
                break;

            case self::STATUS_CONCLUIDO:
                return "<span class='badge badge-info'>Concluído</span>";
                break;

            case self::STATUS_CANCELADO:
                return "<span class='badge badge-secondary'>Cancelado</span>";
                break;

            default:
                return $this->status;
        }
    }

    public function calcularTotalDespesas()
    {
        $total = 0;

        foreach ($this->linhasDespesasReparacao as $despesa)
        {
            $total += ($despesa->preco * $despesa->quantidade);
        }

        return $total;
    }
}
