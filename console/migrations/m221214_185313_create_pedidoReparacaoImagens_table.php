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
            'caminho' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pedido_reparacao_imagens');
    }
}
