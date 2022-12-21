<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gruposItensItem}}`.
 */
class m221204_003507_create_gruposItensItem_table extends Migration
{

    public function up()
    {
        $this->createTable('grupositensitem', [
            'grupoItens_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-grupoitensitem', 'grupositensitem', ['grupoItens_id', 'item_id']);
        $this->addForeignKey('fk-grupoItensitens_grupoitens', 'grupositensitem', 'grupoItens_id', 'grupoitens', 'id');
        $this->addForeignKey('fk-Item', 'grupositensitem', 'item_id', 'item', 'id');
    }

    public function down()
    {
        $this->dropTable('gruposItensItem');
    }
}
