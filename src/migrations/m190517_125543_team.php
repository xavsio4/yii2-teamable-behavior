<?php

use yii\db\Schema;
use yii\db\Migration;

class m190517_125543_team extends Migration
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
            '{{%team}}',
            [
                'id'=> $this->primaryKey(11)->unsigned(),
                'name'=> $this->string(350)->null()->defaultValue(null),
                'color'=> $this->string(20)->null()->defaultValue(null),
                'icon'=> $this->string(180)->null()->defaultValue(null),
                'status'=> $this->integer(11)->null()->defaultValue(null),
                'invitation_email_text'=> $this->string(255)->null()->defaultValue(null),
                'invitation_code'=> $this->integer(22)->null()->defaultValue(null),
                'created_by'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_by'=> $this->integer(11)->null()->defaultValue(null),
                'is_deleted'=> $this->integer(11)->null()->defaultValue(null),
                'deleted_date'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%team}}');
    }
}
