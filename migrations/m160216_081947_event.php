<?php

use yii\db\Schema;
use yii\db\Migration;

class m160216_081947_event extends Migration
{
    public function up()
    {
        $this->createTable(
            'registration_team_member_event',
            [
                'id' => $this->primaryKey(),
                'event_id' => $this->integer()->notNull(),
                'registration_team_member_id' => $this->integer()
            ]
        );

        $this->addForeignKey(
            'registration_team_member_event__registration_team_member',
            'registration_team_member_event',
            'registration_team_member_id',
            'registration_team_member',
            'id'
        );


    }

    public function down()
    {
        $this->dropForeignKey(
            'registration_team_member_event__registration_team_member',
            'registration_team_member_event'
        );
        $this->dropTable('registration_team_member_event');
    }

}
