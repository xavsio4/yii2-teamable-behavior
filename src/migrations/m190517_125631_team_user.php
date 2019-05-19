<?php

use yii\db\Schema;
use yii\db\Migration;

class m190517_125631_team_user extends Migration
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
            '{{%team_user}}',
            [
                'id'=> $this->primaryKey(11)->unsigned(),
                'team_id'=> $this->integer(11)->null()->defaultValue(null),
                'user_id'=> $this->integer(11)->null()->defaultValue(null),
                'created_by'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_by'=> $this->integer(11)->null()->defaultValue(null),
                'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%team_user}}');
    }
}
