<?php

use yii\db\Migration;

/**
 * Class m221101_173329_create_table_empresa
 */
class m221101_173329_create_table_empresa extends Migration
{
    public function up()
    {
        $this->createTable('empresa', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'NIF' => $this->char(9)->notNull(),
            'rua' => $this->string()->notNull(),
            'codigoPostal' => $this->char(8)->notNull(),
            'localidade' => $this->string()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('empresa');
    }
}
