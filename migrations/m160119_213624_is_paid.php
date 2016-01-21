<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_213624_is_paid extends Migration
{
    public function up()
    {
        $this->addColumn(
            'registration_team_member',
            'is_paid',
            $this->boolean()
        );
    }

    public function down()
    {
        $this->dropColumn(
            'registration_team_member',
            'is_paid'
        );
    }

}
