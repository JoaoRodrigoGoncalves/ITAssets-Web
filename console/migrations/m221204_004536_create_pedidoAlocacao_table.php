<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requesicaoItens}}`.
 */
class m221204_004536_create_pedidoAlocacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('pedido_alocacao', [
            'id' => $this->primaryKey(),
            /**
             * Valores padrão do estado
             * 10 -> aberto / em espera
             *  9 -> aprovado
             *  8 -> negado
             *  0 -> cancelado
             */
            'status' => $this->integer()->notNull()->defaultValue(10),
            'item_id' => $this->integer()->null()->defaultValue(null),
            'grupoItem_id' => $this->integer()->null()->defaultValue(null),
            'dataPedido' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'dataInicio' => $this->dateTime(),
            'dataFim' => $this->dateTime(),
            'obs' => $this->text(), // Observação a ser incluída com o pedido
            'obsResposta' => $this->text(), // Observação a ser incluída com a resposta
            'requerente_id' => $this->integer()->notNull(),
            'aprovador_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk-requerente', 'pedido_alocacao', 'requerente_id', 'user', 'id');
        $this->addForeignKey('fk-aprovador', 'pedido_alocacao', 'aprovador_id', 'user', 'id');
        $this->addForeignKey('fk-pedidoalocacao_item', 'pedido_alocacao', 'item_id', 'item', 'id');
        $this->addForeignKey('fk-grupoItem', 'pedido_alocacao', 'grupoItem_id', 'grupoItens', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('pedido_alocacao');
    }
}
