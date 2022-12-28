<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pedidoReparacaoImagens}}`.
 */
class m221214_185313_create_pedidoReparacaoImagens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pedido_reparacao_imagens', [
            'id' => $this->primaryKey(),
            'caminho' => $this->string(),
            'pedidoReparacao_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-pedidoreparacao-img', 'pedido_reparacao_imagens', 'pedidoReparacao_id', 'pedido_reparacao', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pedidoreparacao-img', 'pedido_reparacao_imagens');
        $this->dropTable('pedido_reparacao_imagens');
    }
}
