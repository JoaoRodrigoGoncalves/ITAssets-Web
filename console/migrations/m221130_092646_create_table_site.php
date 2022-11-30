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
            'coordenadas'=>$this->string(),
            'notas'=>$this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('site');
    }
}
