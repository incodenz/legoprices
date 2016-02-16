<?php

namespace app\modules\register\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "registration_team_member_event".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $registration_team_member_id
 *
 * @property \app\modules\register\models\RegistrationTeamMember $registrationTeamMember
 */
class RegistrationTeamMemberEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registration_team_member_event';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Registration Team Member Event} other{Registration Team Member Events}}', ['n' => $n]);
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
            [['event_id'], 'required'],
            [['event_id', 'registration_team_member_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'registration_team_member_id' => 'Registration Team Member ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistrationTeamMember()
    {
        return $this->hasOne(\app\modules\register\models\RegistrationTeamMember::className(), ['id' => 'registration_team_member_id']);
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
            'event_id' => $this->event_id,
            'registration_team_member_id' => $this->registration_team_member_id,
        ]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

