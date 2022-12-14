<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%linhaPedidoReparacao}}`.
 */
class m221214_134329_create_linhaPedidoReparacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('linha_pedido_reparacao', [
            'id' => $this->primaryKey(),
            'obs' => $this->text(),
            'pedido_id' => $this->integer()->notNull(),
            'item_id' => $this->integer(),
            'grupo_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-pedidoreparacao', 'linha_pedido_reparacao', 'pedido_id', 'pedido_reparacao', 'id');
        $this->addForeignKey('fk-pedidoreparacao-item', 'linha_pedido_reparacao', 'item_id', 'item', 'id');
        $this->addForeignKey('fk-pedidoreparacao-grupo', 'linha_pedido_reparacao', 'grupo_id', 'grupoItens', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('linha_pedido_reparacao');
    }
}
