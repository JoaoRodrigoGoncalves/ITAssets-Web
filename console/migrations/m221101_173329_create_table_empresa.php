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
            'nome' => $this->string(),
            'NIF' => $this->char(9),
            'rua' => $this->string(),
            'codigoPostal' => $this->char(8),
            'localidade' => $this->string()
        ]);
    }

    public function down()
    {
        $this->dropTable('empresa');
    }
}
