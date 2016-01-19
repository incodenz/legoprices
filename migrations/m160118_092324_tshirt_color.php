<?php

use yii\db\Schema;
use yii\db\Migration;

class m160118_092324_tshirt_color extends Migration
{
    public function up()
    {
        $this->addColumn(
            'registration_team_member',
            'tshirt_colour',
            $this->string()
        );
    }

    public function down()
    {
        $this->dropColumn(
            'registration_team_member',
            'tshirt_colour'
        );
    }
}
