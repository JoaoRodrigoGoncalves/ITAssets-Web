<?php

use yii\db\Migration;

/**
 * Class m221130_095112_alter_table_item
 */
class m221130_095112_alter_table_item extends Migration
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
        echo "m221130_095112_alter_table_item cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        //adicona os campos a tabela item
        $this->addColumn('item', 'grupoitens_id', $this->integer());
        $this->addColumn('item', 'site_id', $this->integer());

        //define os campos adicionados anteriormente como fk
        $this->addForeignKey('fk-grupoitens', 'item', 'grupoitens_id', 'grupoitens', 'id');
        $this->addForeignKey('fk-site', 'item', 'site_id', 'site', 'id');
    }


    public function down()
    {
        //$this->dropTable('item');
    }
}
