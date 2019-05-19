<?php

use yii\db\Schema;
use yii\db\Migration;

class m190517_125825_asset_team extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%asset_team}}',
            [
                'id'=> $this->primaryKey(11)->unsigned(),
                'team_id'=> $this->integer(11)->null()->defaultValue(null),
                'item_id'=> $this->integer(11)->null()->defaultValue(null),
                'model'=> $this->string(300)->null()->defaultValue(null),
                'created_by'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_by'=> $this->integer(11)->null()->defaultValue(null),
                'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%asset_team}}');
    }
}
