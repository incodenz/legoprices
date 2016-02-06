<?php

use yii\db\Schema;
use yii\db\Migration;

class m160206_195242_tables extends Migration
{
    public function up()
    {
        $this->renameColumn('registration', 'table_size', 'display_tables');
        $this->addColumn('registration', 'sales_tables', $this->string());

        $this->addColumn('registration_team_member', 'hivis', $this->boolean());
        $this->addColumn('registration_team_member', 'show_set', $this->boolean());
    }

    public function down()
    {
        $this->renameColumn('registration', 'display_tables', 'table_size');

        $this->dropColumn('registration', 'sales_tables');
        $this->dropColumn('registration_team_member', 'hivis');
        $this->dropColumn('registration_team_member', 'show_set');
    }


}
