<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "pedido_alocacao".
 *
 * @property int $id
 * @property int $status
 * @property int|null $item_id
 * @property int|null $grupoItem_id
 * @property string $dataPedido
 * @property string|null $dataInicio
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
    const STATUS_DEVOLVIDO = 7;
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
            // https://stackoverflow.com/a/57568061/10935376
            [
                ['item_id'], 'required',
                'when' => function($model)
                {
                    return ($model->grupoItem_id == "");
                },
            ],
            [
                ['grupoItem_id'], 'required',
                'when' => function($model)
                {
                    return ($model->item_id == "");
                }
            ],
            [['dataPedido', 'dataInicio', 'dataFim'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['obs', 'obsResposta'], 'string'],
            [['requerente_id'], 'required'],
            [['dataInicio', 'dataFim', 'obs', 'obsResposta'], 'default', 'value' => null],
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
            'id' => 'ID Pedido',
            'status' => 'Estado',
            'item_id' => 'Item ID',
            'grupoItem_id' => 'Grupo Item ID',
            'dataPedido' => 'Data Pedido',
            'dataInicio' => 'Data Inicio',
            'dataFim' => 'Data Fim',
            'obs' => 'Observações',
            'obsResposta' => 'Notas da Resposta',
            'requerente_id' => 'Requerente',
            'aprovador_id' => 'Aprovador',
        ];
    }

    public function getPrettyStatus()
    {
        switch($this->status)
        {
            case self::STATUS_ABERTO:
                return "<span class='badge badge-primary'>Aberto</span>";
                break;

            case self::STATUS_APROVADO:
                return "<span class='badge badge-success'>Aprovado</span>";
                break;

            case self::STATUS_NEGADO:
                return "<span class='badge badge-danger'>Negado</span>";
                break;

            case self::STATUS_DEVOLVIDO:
                return "<span class='badge badge-info'>Devolvido</span>";
                break;

            case self::STATUS_CANCELADO:
                return "<span class='badge badge-secondary'>Cancelado</span>";
                break;

            default:
                return $this->status;
        }
    }

    /**
     * Cancela todos os pedidos de alocação associados ao item atual
     * que ainda se encontrem abertos.
     */
    public function cancelarPedidosAlocacaoAbertos()
    {
        /**
         * Atualizar todos os pedidos para "Negado" (8), adicionar uma resposta padrão e notificar
         */
        $pedidos = PedidoAlocacao::findAll(['status' => PedidoAlocacao::STATUS_ABERTO, 'item_id' => $this->item_id, 'grupoItem_id' => $this->grupoItem_id]);
        foreach ($pedidos as $pedido) {
            $pedido->status = PedidoAlocacao::STATUS_NEGADO;
            $pedido->obsResposta = 'Item não está atualmente disponível.';
            $pedido->aprovador_id = $this->aprovador_id;
            if($pedido->save())
            {
                Notificacoes::addNotification(
                    $pedido->requerente_id,
                    "O Pedido de Alocação Nº" . $pedido->id . " foi atualizado.",
                    Url::to(['pedidoalocacao/view', 'id' => $pedido->id])
                );
            }
        }
    }

    /**
     * Utility para ir buscar o nome do objeto e não ser preciso
     * estar constantemente a fazer a mesma verificação
    */
    public function getObjectName()
    {
        if($this->item != null)
        {
            return $this->item->nome;
        }

        if($this->grupoItem != null)
        {
            return $this->grupoItem->nome;
        }

        return null;
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
