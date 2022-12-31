<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notificacoes}}`.
 */
class m221230_114831_create_notificacoes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notificacoes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'link' => $this->string()->null(),
            'datetime' => $this->dateTime()->defaultExpression("NOW()"),
            'read' => $this->boolean()->defaultValue(false)
        ]);

        $this->addForeignKey('fk-user-notificacoes', 'notificacoes', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user-notificacoes', 'notificacoes');
        $this->dropTable('notificacoes');
    }
}
