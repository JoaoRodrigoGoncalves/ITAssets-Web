<?php

use yii\db\Migration;

/**
 * Class m221117_140648_create_table_item
 */
class m221117_140648_create_table_item extends Migration
{
    public function up()
    {
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'serialNumber' => $this->string(),
            'categoria_id' => $this->integer(),
            'notas' => $this->string(),
            'status' => $this->integer()->defaultValue(10)
        ]);

        $this->addForeignKey('fk-categoria', 'item', 'categoria_id', 'categoria', 'id');
    }

    public function down()
    {
        $this->dropTable('item');
    }
}
