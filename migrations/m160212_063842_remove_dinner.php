<?php

use yii\db\Schema;
use yii\db\Migration;

class m160212_063842_remove_dinner extends Migration
{
    public function up()
    {
        $this->dropColumn(
            'registration_team_member',
            'option_dinner'
        );
    }

    public function down()
    {
        $this->addColumn(
            'registration_team_member',
            'option_dinner',
            $this->boolean()
        );
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
