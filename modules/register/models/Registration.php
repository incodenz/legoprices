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

    const FEE = '$10.00';
    const SCENARIO_START = 'start';
    const SCENARIO_MAIN = 'main';

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

    private static $_tables = [
        'Half',
        'Full',
        'Double',
        'Triple',
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
    public static function getTables()
    {
        return self::$_tables;
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
                [['type_id', 'exhibit_details', 'table_size'], 'required', 'on' => self::SCENARIO_MAIN],
                ['terms', 'compare', 'compareValue' => 1, 'message' => 'Terms & Conditions must be accepted'],
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
