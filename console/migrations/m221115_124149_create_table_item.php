<?php

use yii\db\Migration;

/**
 * Class m221115_124149_create_table_item
 */
class m221115_124149_create_table_item extends Migration
{
    public function up()
    {
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(),
            'serialNumber' => $this->string(),
            'notas' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('item');
    }
}
