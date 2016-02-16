<?php

namespace app\modules\register\models;

use app\modules\register\models\base\RegistrationTeamMemberEvent;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "registration_team_member".
 */
class RegistrationTeamMember extends \app\modules\register\models\base\RegistrationTeamMember
{
    //const SCENARIO_PRIMARY = 'primary';
    const SCENARIO_SECONDARY_SELF = 'secondary_self';
    const SCENARIO_SECONDARY = 'secondary';

    public $add_events;

    private static $_events = [
        1 => [
            'id' => 1,
            'day' => 'Saturday',
            'time' => '9am - 10am',
            'title' => 'Photography',
            'description' => 'go through the basics on how to set up, what equipment is needed, and how to use it all.'
        ],
        2 => [
            'id' => 2,
            'day' => 'Saturday',
            'time' => '11am - 12noon',
            'title' => 'Stop Motion',
            'description' => 'showing the basics on how to set up the right lighting, what cameras and programs to use and where to get it all from.'
        ],
        3 => [
            'id' => 3,
            'day' => 'Saturday',
            'time' => '12noon - 1pm',
            'title' => 'Children’s workshop',
            'description' => 'fun activities and challenges for the hour.'
        ],
        4 => [
            'id' => 4,
            'day' => 'Saturday',
            'time' => '1pm - 2pm',
            'title' => 'Mindstorm Basics',
            'description' => 'hands on taking a look at a new set and going through how to set it all up. '
        ],
        5 => [
            'id' => 5,
            'day' => 'Saturday',
            'time' => '3pm - 4pm',
            'title' => 'Building Techniques',
            'description' => 'how to build unique and crazy rock formations and other techniques on how these guys build.  Opportunity to try it out too. '
        ],
        6 => [
            'id' => 6,
            'day' => 'Sunday',
            'time' => '9am - 10am',
            'title' => 'Photography',
            'description' => 'go through the basics on how to set up, what equipment is needed, and how to use it all.'
        ],
        7 => [
            'id' => 7,
            'day' => 'Sunday',
            'time' => '11am - 12noon',
            'title' => 'Stop Motion',
            'description' => 'showing the basics on how to set up the right lighting, what cameras and programs to use and where to get it all from.'
        ],
        8 => [
            'id' => 8,
            'day' => 'Sunday',
            'time' => '12noon - 1pm',
            'title' => 'Children’s workshop',
            'description' => 'fun activities and challenges for the hour.'
        ],
        9 => [
            'id' => 9,
            'day' => 'Sunday',
            'time' => '1pm - 2pm',
            'title' => 'Mindstorm Basics',
            'description' => 'hands on taking a look at a new set and going through how to set it all up. '
        ],
        10 => [
            'id' => 10,
            'day' => 'Sunday',
            'time' => '3pm - 4pm',
            'title' => 'Building Techniques',
            'description' => 'how to build unique and crazy rock formations and other techniques on how these guys build.  Opportunity to try it out too. '
        ],

    ];

    public static function getEvents()
    {
        return self::$_events;
    }
    /**
     * @param Registration $registration
     * @return array
     */
    public static function shirtColours($registration)
    {
        switch($registration->type_id) {
            case Registration::TYPE_VOLUNTEER:
                return ['Volunteer Yellow'];
            default:
                return ['Blue', 'Green'];
        }
    }
    public static function shirtSizes()
    {
        return [
            'Childrens' => [
                'Childrens 6' => '6',
                'Childrens 8' => '8',
                'Childrens 10' => '10',
                'Childrens 12' => '12',
                'Childrens 14' => '14',
                'Childrens 16' => '16',
            ],
            'Womens' => [
                'Womens 6' => '6',
                'Womens 8' => '8',
                'Womens 10' => '10',
                'Womens 12' => '12',
                'Womens 14' => '14',
                'Womens 16' => '16',
                'Womens 18' => '18',
                'Womens 20' => '20',
            ],
            'Mens' => [
                'Mens S' => 'Small',
                'Mens M' => 'Medium',
                'Mens L' => 'Large',
                'Mens XL' => 'XL',
                'Mens 2XL' => '2XL',
                'Mens 3XL' => '3XL',
                'Mens 4XL' => '4XL',
                'Mens 5XL' => '5XL',
            ]
        ];
    }

    public function __toString()
    {
        return $this->first_name && $this->last_name ? $this->first_name.' '.$this->last_name : 'No Name';
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SECONDARY] = ['first_name', 'last_name', 'email'];

        return $scenarios;
    }
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                ['email', 'email'],
                //['email', 'exist', 'targetAttribute' => 'primary_contact'],
                [['first_name', 'last_name', 'emergency_contact'], 'required'],
                [['parental_consent'], function ($attr) {
                    if (!$this->over_18 && !$this->$attr) {
                        $this->addError($attr, $this->getAttributeLabel($attr).' Required if under 18');
                    }
                }, 'skipOnEmpty' => false],
                [['first_name', 'last_name', 'email'], 'required', 'on' => self::SCENARIO_SECONDARY],
                ['add_events', 'safe'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'option_afol' => 'Attend the AFOL event on Saturday evening',
                'tshirt_size' => 'T-Shirt Size',
                'tshirt_colour' => 'T-Shirt Colour',
                'over_18' => 'Over 18',
                'hivis' => 'Can you provide your own Hi-Vis vest? (Health & Safety requirements)',
                'show_set' => 'Yes, I want to purchase the registration exclusive "Christchurch Railway Station" set for '.Yii::$app->formatter->asCurrency(Registration::SHOW_SET_FEE)

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

    public function addScenario()
    {
        if ($this->primary_contact) {
            $this->scenario = RegistrationTeamMember::SCENARIO_DEFAULT;
        } elseif ($this->email_me) {
            //$this->scenario = RegistrationTeamMember::SCENARIO_SECONDARY_SELF;
            $this->scenario = RegistrationTeamMember::SCENARIO_SECONDARY;
        } else {
            $this->scenario = RegistrationTeamMember::SCENARIO_DEFAULT;
        }
    }
    public function getContinueUrl()
    {
        return \yii\helpers\Url::to(['/register/update', 'id' => $this->id, 'hash' => $this->hash], 'http');
    }
    public function getHash()
    {
        return sha1($this->id.'CBS_2016'.$this->created_at.$this->registration_id);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        if ($this->add_events) {
            $this->handleEvents();
        }
    }

    private function handleEvents()
    {
        // delete any events that have been removed.
        $currentEvents = ArrayHelper::map($this->registrationTeamMemberEvents, 'id', 'event_id');
        foreach($currentEvents as $id => $event_id) {
            if (!in_array($event_id, $this->add_events)) {
                $e = RegistrationTeamMemberEvent::findOne($id);
                $e->delete();
            }
        }
        // add any new ones
        foreach($this->add_events as $event_id) {
            if (!in_array($event_id, $currentEvents)) {
                $e = new RegistrationTeamMemberEvent();
                $e->event_id = $event_id;
                $e->registration_team_member_id = $this->id;
                $e->save();
            }
        }
        unset($this->registrationTeamMemberEvents);
    }
    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->add_events = ArrayHelper::map($this->registrationTeamMemberEvents, 'id', 'event_id');
    }
}
