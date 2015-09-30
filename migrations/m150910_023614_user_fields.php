<?php

use yii\db\Schema;
use yii\db\Migration;

class m150910_023614_user_fields extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'last_login', $this->timestamp());
        $this->addColumn('user', 'failed_attempts', $this->smallInteger(3));
        $this->addColumn('user', 'password_change_date', $this->timestamp());
    }

    public function down()
    {
        $this->dropColumn('user', 'last_login');
        $this->dropColumn('user', 'failed_logins');
        $this->dropColumn('user', 'password_change_date');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
