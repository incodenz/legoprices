<?php

use yii\db\Migration;
use app\models\User;

class m150524_220222_MasterUser extends Migration
{
    public function safeUp()
    {
        $this->insert('user', [
            'email' => 'master@incode.co.nz',
            'first_name' => 'master',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('master'),
            'status_id' => User::STATUS_ACTIVE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'role_id' => User::ROLE_ADMIN,
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', ['email' => 'master@webtools.co.nz']);
    }
}
