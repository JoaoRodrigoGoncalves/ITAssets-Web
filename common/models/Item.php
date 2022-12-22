<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $serialNumber
 * @property int|null $categoria_id
 * @property string|null $notas
 * @property int|null $status
 * @property int|null $grupoitens_id
 * @property int|null $site_id
 *
 * @property Categoria $categoria
 * @property Grupoitens[] $grupoItens
 * @property GruposItens_Item[] $grupositensitems
 * @property PedidoAlocacao[] $pedidoAlocacaos
 * @property LinhaPedidoReparacao[] $linhaPedidoReparacaos
 * @property Site $site
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
            [['nome'], 'required'],
            [['categoria_id', 'status', 'site_id'], 'integer'],
            [['nome', 'serialNumber', 'notas'], 'string', 'max' => 255],
            [['serialNumber', 'notas'], 'default', 'value' => null],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::class, 'targetAttribute' => ['site_id' => 'id']],
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
            'status' => 'Status',
            'site_id' => 'Local',
        ];
    }

    // Para a API
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['categoria_id'], $fields['site_id']);
        $fields['categoria'] = function ($model) {
            return $this->categoria;
        };
        $fields['site'] = function ()
        {
            return $this->site;
        };
        return $fields;
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

    /**
     * Gets query for [[GrupoItens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoItens()
    {
        return $this->hasMany(Grupoitens::class, ['id' => 'grupoItens_id'])->viaTable('grupositensitem', ['item_id' => 'id']);
    }

    /**
     * Gets query for [[Grupositensitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupositensitems()
    {
        return $this->hasMany(GruposItens_Item::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[LinhaPedidoReparacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhaPedidoReparacaos()
    {
        return $this->hasMany(LinhaPedidoReparacao::class, ['item_id' => 'id']);
    }

    /**
     * Gets query for [[PedidoAlocacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedidoAlocacaos()
    {
        return $this->hasMany(PedidoAlocacao::class, ['item_id' => 'id']);
    }

    public function isInActivePedidoAlocacao()
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

    public function isInActiveItemsGroup()
    {
        if($this->grupoItens != null)
        {
            foreach ($this->grupoItens as $grupoitem) {
                if($grupoitem->status == Grupoitens::STATUS_ACTIVE)
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

    /**
     * Gets query for [[Site]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::class, ['id' => 'site_id']);
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
