<?php

use yii\db\Migration;

/**
 * Class m221130_092646_create_table_site
 */
class m221130_092646_create_table_site extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221130_092646_create_table_site cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->createTable('site', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'rua' => $this->string(),
            'localidade' => $this->string(),
            'codPostal' => $this->char(8),
            'coordenadas'=>$this->string(),
            'notas'=>$this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('site');
    }
}
