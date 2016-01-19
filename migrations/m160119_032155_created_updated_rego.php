<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_032155_created_updated_rego extends Migration
{
    public function up()
    {
        $this->addColumn(
            'registration',
            'created_at',
            $this->timestamp()
        );
        $this->addColumn(
            'registration',
            'updated_at',
            $this->timestamp()
        );

        $this->addColumn(
            'registration_team_member',
            'created_at',
            $this->timestamp()
        );
        $this->addColumn(
            'registration_team_member',
            'updated_at',
            $this->timestamp()
        );
    }

    public function down()
    {
        $this->dropColumn(
            'registration',
            'created_at'
        );
        $this->dropColumn(
            'registration',
            'updated_at'
        );

        $this->dropColumn(
            'registration_team_member',
            'created_at'
        );
        $this->dropColumn(
            'registration_team_member',
            'updated_at'
        );
    }

}
