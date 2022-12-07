<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gruposItensItem}}`.
 */
class m221204_003507_create_gruposItensItem_table extends Migration
{

    public function up()
    {
        $this->createTable('gruposItensItem', [
            'grupoItens_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-grupoitensitem', 'gruposItensItem', ['grupoItens_id', 'item_id']);
        $this->addForeignKey('fk-grupoItensitens_grupoitens', 'gruposItensItem', 'grupoItens_id', 'grupoItens', 'id');
        $this->addForeignKey('fk-Item', 'gruposItensItem', 'item_id', 'item', 'id');
    }

    public function down()
    {
        $this->dropTable('gruposItensItem');
    }
}
