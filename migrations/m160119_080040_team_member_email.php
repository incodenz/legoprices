<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_080040_team_member_email extends Migration
{
    public function up()
    {
        $this->addColumn(
            'registration_team_member',
            'email_me',
            $this->boolean()
        );
    }

    public function down()
    {
        $this->dropColumn(
            'registration_team_member',
            'email_me'
        );
    }


}
