<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property LinhaPedidoReparacao[] $linhaPedidoReparacaos
 * @property PedidoAlocacao[] $pedidoAlocacaos
 */
class Grupoitens extends ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETED = 0;

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
            [['notas'], 'default', 'value' => null],
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

    public function fields()
    {
        $fields = parent::fields();
        $fields['itens'] = function ($model) {
            return $this->items;
        };
        return $fields;
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
     * Gets query for [[Items0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['id' => 'item_id'])->viaTable('grupositensitem', ['grupoItens_id' => 'id']);
    }

    /**
     * Gets query for [[LinhaPedidoReparacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaPedidoReparacaos()
    {
        return $this->hasMany(LinhaPedidoReparacao::class, ['grupo_id' => 'id']);
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

    public function isinActivePedidoAlocacao()
    {
        if($this->pedidoAlocacaos != null)
        {
            foreach ($this->pedidoAlocacaos as $pedidoAlocacao) {
                if($pedidoAlocacao->status == PedidoAlocacao::STATUS_APROVADO)
                    return true;
            }
        }
        return false;
    }

    public function isInActivePedidoReparacao()
    {
        if($this->linhaPedidoReparacaos != null)
        {
            foreach ($this->linhaPedidoReparacaos as $linhaPedidoReparacao) {
                if(in_array($linhaPedidoReparacao->pedido->status, [PedidoReparacao::STATUS_ABERTO, PedidoReparacao::STATUS_EM_REVISAO]))
                    return true;
            }
        }
        return false;
    }

    public function isAlocatedToUser($userID)
    {
        if($this->isInActivePedidoAlocacao())
        {
            foreach ($this->pedidoAlocacaos as $pedidoAlocacao) {
                if($pedidoAlocacao->status == PedidoAlocacao::STATUS_APROVADO && $pedidoAlocacao->requerente_id == $userID)
                    return true;
            }
        }
        return false;
    }

    public function getDataAlocacaoBaseadoEmData($date)
    {
        if(count($this->pedidoAlocacaos) < 1)
            return null;

        $dataAlocacao = date("Y-m-d H:i:s", 0);
        foreach ($this->pedidoAlocacaos as $pedidoAlocacao)
        {
            if($pedidoAlocacao->dataInicio != null)
            {
                if($pedidoAlocacao->dataInicio < date_create($date) && $pedidoAlocacao->dataInicio > $dataAlocacao)
                {
                    $dataAlocacao = $pedidoAlocacao->dataInicio;
                }
            }
        }

        return $dataAlocacao;
    }

    public function listItensHumanReadable($maxChar = null)
    {
        $string = "";

        foreach ($this->items as $item) {
            $string .= $item->nome . ", ";
        }

        $string = substr($string, 0, -2);

        if($maxChar != null)
        {
            return substr($string, 0, $maxChar) . "...";
        }
        return $string;
    }
}
