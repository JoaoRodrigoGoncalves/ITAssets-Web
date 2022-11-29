<?php

use yii\db\Migration;

/**
 * Class m221117_130612_create_table_categoria
 */
class m221117_130612_create_table_categoria extends Migration
{

    public function up()
    {
        $this->createTable('categoria', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'status' => $this->integer()->defaultValue(10)
        ]);
    }

    public function down()
    {
        $this->dropTable('categoria');
    }
}
