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
            'requerente_id' => $this->integer()->notNull(),
            'responsavel_id' => $this->integer(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'respostaObs' => $this->text()
        ]);

        $this->addForeignKey('fk-requerente-user-reparacao', 'pedido_reparacao', 'requerente_id', 'user', 'id');
        $this->addForeignKey('fk-responsavel-user-reparacao', 'pedido_reparacao', 'responsavel_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-requerente-user-reparacao', 'pedido_reparacao');
        $this->dropForeignKey('fk-responsavel-user-reparacao', 'pedido_reparacao');

        $this->dropTable('pedido_reparacao');
    }
}
