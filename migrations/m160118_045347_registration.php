<?php

use yii\db\Schema;
use yii\db\Migration;

class m160118_045347_registration extends Migration
{
    public function up()
    {
        $this->createTable(
            'registration',
            [
                'id' => $this->primaryKey(),

                'status_id' => $this->integer(),

                'type_id' => $this->integer(),

                'exhibit_details' => $this->text(),
                'table_size' => $this->text(),

                'power_required' => $this->boolean(),
                'travel_grant' => $this->text(),

                'terms' => $this->boolean(),

                'comments' => $this->text(),

                /*
                'option_exhibitor' => $this->boolean(),
                'option_sales' => $this->boolean(),
                'option_volunteer' => $this->boolean(),
                */
            ]
        );
        $this->createTable(
            'registration_team_member',
            [
                'id' => $this->primaryKey(),
                'registration_id' => $this->integer(),
                'primary_contact' => $this->boolean(),

                'first_name' => $this->string(),
                'last_name' => $this->string(),
                'email' => $this->string(),

                'password' => $this->string(),
                'ext_hash' => $this->string(),

                'contact_number' => $this->string(),
                'address' => $this->string(),

                'option_dinner' => $this->boolean(),
                'option_afol' => $this->boolean(),

                'over_18' => $this->boolean(),
                'parental_consent' => $this->boolean(),

                'emergency_contact' => $this->string(),
                'dietary_requirements' => $this->string(),

                'tshirt_size' => $this->string(),


            ]
        );

        $this->addForeignKey(
            'registration_team_idx',
            'registration_team_member',
            'registration_id',
            'registration',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('registration_team_idx', 'registration_team_member');
        $this->dropTable(
            'registration'
        );
        $this->dropTable(
            'registration_team_member'
        );
    }

}
