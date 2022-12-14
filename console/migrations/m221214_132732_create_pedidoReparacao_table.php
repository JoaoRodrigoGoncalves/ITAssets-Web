<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pedidoReparacao}}`.
 */
class m221214_132732_create_pedidoReparacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pedido_reparacao', [
            'id' => $this->primaryKey(),
            'dataPedido' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'dataInicio' => $this->dateTime(),
            'dataFim' => $this->dateTime(),
            'descricaoProblema' => $this->text()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'respostaObs' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pedido_reparacao');
    }
}
