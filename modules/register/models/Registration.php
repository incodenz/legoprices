<?php

namespace app\modules\register\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "registration".
 */
class Registration extends \app\modules\register\models\base\Registration
{
    const TYPE_EXHIBIT = 10;
    const TYPE_SALES = 20;
    const TYPE_BOTH = 30;
    const TYPE_VOLUNTEER = 40;

    const STATUS_NEW = 10;
    const STATUS_SUBMITTED = 20;
    const STATUS_PAYMENT_RECEIVED = 30;
    const STATUS_CONFIRMED = 50;

    const REGISTRATION_FEE = 20;
    const ADDITIONAL_FEE = 10;

    const SHOW_SET_FEE = 35;

    const SALES_TABLE_FEE = 200;
    const TURN_OVER_PERCENT = 5;

    const SCENARIO_START = 'start';
    const SCENARIO_MAIN = 'main';

    const TABLE_SINGLE = 'Single table';
    const TABLE_2LONG = '2 tables long';
    const TABLE_3LONG = '3 tables long';
    const TABLE_4LONG = '4 tables long';
    const TABLE_1LONG2DEEP = '2 tables deep';
    const TABLE_2LONG2DEEP = '2 tables long, 2 deep';
    const TABLE_3LONG2DEEP = '3 tables long, 2 deep';
    const TABLE_4LONG2DEEP = '4 tables long, 2 deep';
    const TABLE_2CORNER = '2 corner tables';

    public $team_members;

    private static $_types = [
        self::TYPE_VOLUNTEER => 'Volunteer',
        self::TYPE_EXHIBIT => 'Show off my collection',
        self::TYPE_SALES => 'Sell products',
        self::TYPE_BOTH => 'Show off my collection & sell products',
    ];

    private static $_statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_SUBMITTED => 'Awaiting Payment',
        self::STATUS_PAYMENT_RECEIVED => 'Payment Received',
        self::STATUS_CONFIRMED => 'Confirmed',
    ];

    private static $_display_tables = [
        self::TABLE_SINGLE,
        self::TABLE_2LONG,
        self::TABLE_3LONG,
        self::TABLE_4LONG,
        self::TABLE_1LONG2DEEP,
        self::TABLE_2LONG2DEEP,
        self::TABLE_3LONG2DEEP,
        self::TABLE_4LONG2DEEP,
        self::TABLE_2CORNER,
    ];

    private static $_sales_tables = [
        self::TABLE_SINGLE,
        self::TABLE_2LONG,
        self::TABLE_3LONG,
        self::TABLE_4LONG,
        self::TABLE_1LONG2DEEP,
        self::TABLE_2LONG2DEEP,
        self::TABLE_3LONG2DEEP,
        self::TABLE_4LONG2DEEP,
        self::TABLE_2CORNER,
    ];

    private static $_sales_table_quantity = [
        self::TABLE_SINGLE => 1,
        self::TABLE_2LONG => 2,
        self::TABLE_3LONG => 3,
        self::TABLE_4LONG => 4,
        self::TABLE_1LONG2DEEP => 2,
        self::TABLE_2LONG2DEEP => 4,
        self::TABLE_3LONG2DEEP => 6,
        self::TABLE_4LONG2DEEP => 8,
        self::TABLE_2CORNER => 2,
    ];

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_START] = [
            'team_members',
            'type_id',
        ];

        return $scenarios;
    }
    public static function getTypes()
    {
        return self::$_types;
    }
    public static function getDisplayTables()
    {
        return self::$_display_tables;
    }
    public static function getSalesTables()
    {
        return self::$_sales_tables;
    }
    public function getSalesTableCost() {
        return ArrayHelper::getValue(self::$_sales_table_quantity, $this->sales_tables, 1) * self::SALES_TABLE_FEE;
    }
    public function getStatuses()
    {
        return self::$_statuses;
    }
    public function getType()
    {
        return ArrayHelper::getValue(self::getTypes(), $this->type_id, null);
    }
    public function getStatus()
    {
        return ArrayHelper::getValue(self::getStatuses(), $this->status_id, self::getStatuses()[self::STATUS_NEW]);
    }

    public function getPrimaryTeamMember()
    {
        foreach($this->registrationTeamMembers as $registrationTeamMember) {
            if ($registrationTeamMember->primary_contact) {
                return $registrationTeamMember;
            }
        }

        $registrationTeamMember = new RegistrationTeamMember();
        $registrationTeamMember->primary_contact = 1;

        return $registrationTeamMember;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'type_id' => 'I want to ',
                'team_members' => 'How many people are helping you',
                'display_tables' => 'How many tables for your Display',
                'sales_tables' => 'How many tables for selling',

                'collab_city' => 'Take part in the City collaboration',
                'collab_moonbase' => 'Take part in the Moonbase-42 collaboration',
                'collab_gbc' => 'Take part in the GBC collaboration',
                'collab_glowindark' => 'Take part in the Glow in the Dark collaboration',
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                ['team_members', 'integer', 'min' => 0, 'max' => 10],
                [['type_id'], 'required', 'on' => self::SCENARIO_MAIN],

                ['terms', 'compare', 'compareValue' => 1, 'message' => 'Terms & Conditions must be accepted'],
                ['sales_tables', 'required', 'when' => function($model) {
                    return $model->type_id == self::TYPE_SALES || $model->type_id = self::TYPE_BOTH;
                }],
                [['display_tables', 'exhibit_details'], 'required', 'when' => function($model) {
                    return $model->type_id == self::TYPE_EXHIBIT || $model->type_id = self::TYPE_BOTH;
                }],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ]
        ];
    }

    public function getContinueUrl()
    {
        return \yii\helpers\Url::to(['/register/confirm', 'id' => $this->id, 'hash' => $this->hash], 'http');
    }
    public function getHash()
    {
        return sha1($this->id.'CBS_2016'.$this->created_at.$this->type_id);
    }

    public function addScenario()
    {
        if ($this->type_id != self::TYPE_VOLUNTEER) {
            $this->scenario = self::SCENARIO_MAIN;
        }
    }

    public function isPaid()
    {
        $paid = true;
        foreach($this->registrationTeamMembers as $teamMember) {
            if (!$teamMember->is_paid) {
                $paid = false;
            }
        }
        if ($this->status_id == self::STATUS_SUBMITTED && $paid) {
            $this->status_id = self::STATUS_PAYMENT_RECEIVED;
            $this->save(false, ['status_id']);
        } elseif ($this->status_id == self::STATUS_PAYMENT_RECEIVED && !$paid) {
            $this->status_id = self::STATUS_SUBMITTED;
            $this->save(false, ['status_id']);
        }
        return $paid;
    }
}
