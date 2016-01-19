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

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                ['email', 'email'],
                //['email', 'exist', 'targetAttribute' => 'primary_contact'],
                [['first_name', 'last_name'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'tshirt_size' => 'T-Shirt Size',
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
}
