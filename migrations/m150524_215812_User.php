<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_215812_User extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id'=> Schema::TYPE_PK.'',
            'email'=> Schema::TYPE_STRING.'(90) NOT NULL',
            'first_name'=> Schema::TYPE_STRING.'(90) NOT NULL',
            'last_name'=> Schema::TYPE_STRING.'(90)',
            'auth_key'=> Schema::TYPE_STRING.'(32)',
            'password_hash'=> Schema::TYPE_STRING.'(255)',
            'password_reset_token'=> Schema::TYPE_STRING.'(255)',
            'password_reset_token_created'=> Schema::TYPE_TIMESTAMP.'',
            'status_id'=> Schema::TYPE_SMALLINT.'(4)',
            'created_at'=> Schema::TYPE_TIMESTAMP.'',
            'updated_at'=> Schema::TYPE_TIMESTAMP.'',
            'role_id'=> Schema::TYPE_SMALLINT.'(2) NOT NULL',
        ], 'ENGINE=InnoDB');

        $this->createIndex('id_UNIQUE', 'user','id',1);
        $this->createIndex('email_UNIQUE', 'user','email',1);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
