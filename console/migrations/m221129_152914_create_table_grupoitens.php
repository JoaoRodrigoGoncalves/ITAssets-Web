<?php

use yii\db\Migration;

/**
 * Class m221129_152914_create_table_grupoitens
 */
class m221129_152914_create_table_grupoitens extends Migration
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
        echo "m221129_152914_create_table_grupoitens cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('grupoitens', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'notas'=>$this->string(),

        ]);
    }

    public function down()
    {
        $this->dropTable('grupoitens');
    }

}
