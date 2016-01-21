<?php

namespace app\modules\register\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "registration_team_member".
 *
 * @property integer $id
 * @property integer $registration_id
 * @property integer $primary_contact
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $ext_hash
 * @property string $contact_number
 * @property string $address
 * @property integer $option_dinner
 * @property integer $option_afol
 * @property integer $over_18
 * @property integer $parental_consent
 * @property string $emergency_contact
 * @property string $dietary_requirements
 * @property string $tshirt_size
 * @property string $tshirt_colour
 * @property string $created_at
 * @property string $updated_at
 * @property integer $email_me
 * @property integer $is_paid
 *
 * @property \app\modules\register\models\Registration $registration
 */
class RegistrationTeamMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registration_team_member';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Registration Team Member} other{Registration Team Members}}', ['n' => $n]);
    }

    /**
     *
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_id', 'primary_contact', 'option_dinner', 'option_afol', 'over_18', 'parental_consent', 'email_me', 'is_paid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'email', 'password', 'ext_hash', 'contact_number', 'address', 'emergency_contact', 'dietary_requirements', 'tshirt_size', 'tshirt_colour'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_id' => 'Registration ID',
            'primary_contact' => 'Primary Contact',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'ext_hash' => 'Ext Hash',
            'contact_number' => 'Contact Number',
            'address' => 'Address',
            'option_dinner' => 'Option Dinner',
            'option_afol' => 'Option Afol',
            'over_18' => 'Over 18',
            'parental_consent' => 'Parental Consent',
            'emergency_contact' => 'Emergency Contact',
            'dietary_requirements' => 'Dietary Requirements',
            'tshirt_size' => 'Tshirt Size',
            'tshirt_colour' => 'Tshirt Colour',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'email_me' => 'Email Me',
            'is_paid' => 'Is Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistration()
    {
        return $this->hasOne(\app\modules\register\models\Registration::className(), ['id' => 'registration_id']);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = null)
    {
        $query = self::find();

        if ($params === null) {
            $params = Yii::$app->request->get($this->formName(), array());
        }

        $this->load($params, $this->formName());

        $query->andFilterWhere([
            'id' => $this->id,
            'registration_id' => $this->registration_id,
            'primary_contact' => $this->primary_contact,
            'option_dinner' => $this->option_dinner,
            'option_afol' => $this->option_afol,
            'over_18' => $this->over_18,
            'parental_consent' => $this->parental_consent,
            'email_me' => $this->email_me,
            'is_paid' => $this->is_paid,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'ext_hash', $this->ext_hash])
            ->andFilterWhere(['like', 'contact_number', $this->contact_number])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'emergency_contact', $this->emergency_contact])
            ->andFilterWhere(['like', 'dietary_requirements', $this->dietary_requirements])
            ->andFilterWhere(['like', 'tshirt_size', $this->tshirt_size])
            ->andFilterWhere(['like', 'tshirt_colour', $this->tshirt_colour])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

