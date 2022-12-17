<?php

use yii\db\Migration;

/**
 * Class m221130_095112_alter_table_item
 */
class m221130_095112_alter_table_item extends Migration
{
    public function up()
    {
        $this->addColumn('item', 'site_id', $this->integer());
        $this->addForeignKey('fk-site', 'item', 'site_id', 'site', 'id');
    }


    public function down()
    {
        $this->dropForeignKey('fk-site', 'item');
        $this->dropColumn('item', 'site_id');
    }
}
