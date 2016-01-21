<?php

use yii\db\Schema;
use yii\db\Migration;

class m160121_074948_collab extends Migration
{
    public function up()
    {
        $this->addColumn(
            'registration',
            'collab_city',
            $this->string()
        );
        $this->addColumn(
            'registration',
            'collab_moonbase',
            $this->string()
        );
        $this->addColumn(
            'registration',
            'collab_gbc',
            $this->string()
        );
        $this->addColumn(
            'registration',
            'collab_glowindark',
            $this->string()
        );
    }

    public function down()
    {
        $this->dropColumn(
            'registration',
            'collab_city'
        );
        $this->dropColumn(
            'registration',
            'collab_moonbase'
        );
        $this->dropColumn(
            'registration',
            'collab_gbc'
        );
        $this->addColumn(
            'registration',
            'collab_glowindark',
            $this->string()
        );
    }

}
