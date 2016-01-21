<?php

namespace app\modules\register\models;

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

    public static function shirtColours()
    {
        return [
            'Red',
            'Blue',
            'Indigo',
            'Violet',
        ];
    }
    public static function shirtSizes()
    {
        return [
            'Childrens' => [
                'Childrens 6' => '6',
                'Childrens 8' => '8',
                'Childrens 12' => '12',
                'Childrens 14' => '14',
            ],
            'Womens' => [
                'Womens 6' => '6',
                'Womens 8' => '8',
                'Womens 12' => '12',
                'Womens 14' => '14',
                'Womens 16' => '16',
                'Womens 18' => '18',
            ],
            'Mens' => [
                'Mens S' => 'Small',
                'Mens M' => 'Medium',
                'Mens L' => 'Large',
                'Mens XL' => 'X-Large',
                'Mens XXL' => 'XX-Large',
                'Mens XXXL' => 'XXX-Large',
            ]
        ];
    }

    public function __toString()
    {
        return $this->first_name.' '.$this->last_name;
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
                [['first_name', 'last_name'], 'required'],
                [['parental_consent', 'emergency_contact'], function ($attr) {
                    if (!$this->over_18 && !$this->$attr) {
                        $this->addError($attr, $this->getAttributeLabel($attr).' Required if under 18');
                    }
                }, 'skipOnEmpty' => false],
                ['option_afol', function () {
                    if ($this->option_afol && !$this->over_18) {
                        $this->addError('option_afol', 'Unable to goto AFOL event if under 18');
                    }
                }],
                [['first_name', 'last_name', 'email'], 'required', 'on' => self::SCENARIO_SECONDARY],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'option_afol' => 'Attend the AFOL event on Saturday evening',
                'option_dinner' => 'Attend the Social Dinner on Friday evening',
                'tshirt_size' => 'T-Shirt Size',
                'tshirt_colour' => 'T-Shirt Colour',
                'over_18' => 'Over 18',

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
}
