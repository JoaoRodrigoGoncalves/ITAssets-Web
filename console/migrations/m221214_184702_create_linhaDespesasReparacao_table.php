<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%linhaDespesasReparacao}}`.
 */
class m221214_184702_create_linhaDespesasReparacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('linha_despesas_reparacao', [
            'id' => $this->primaryKey(),
            'descricao' => $this->string(),
            'quantidade' => $this->float(),
            'preco' => $this->double(),
            'pedidoReparacao_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-pedidoreparacao-despesas', 'linha_despesas_reparacao', 'pedidoReparacao_id', 'pedido_reparacao', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pedidoreparacao-despesas', 'linha_despesas_reparacao');
        $this->dropTable('linha_despesas_reparacao');
    }
}
