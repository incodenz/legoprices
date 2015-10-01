<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "notification_set".
 *
 * @property integer $id
 * @property integer $notification_address_id
 * @property string $set_code
 * @property integer $percent_off
 * @property integer $status_id
 * @property string $sent_at
 * @property string $created_at
 * @property string $hash
 *
 * @property \app\models\NotificationAddress $notificationAddress
 */
class NotificationSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_set';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Notification Set} other{Notification Sets}}', ['n' => $n]);
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
            [['notification_address_id', 'percent_off', 'status_id'], 'required'],
            [['notification_address_id', 'percent_off', 'status_id'], 'integer'],
            [['sent_at', 'created_at'], 'safe'],
            [['set_code', 'hash'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_address_id' => 'Notification Address ID',
            'set_code' => 'Set Code',
            'percent_off' => 'Percent Off',
            'status_id' => 'Status ID',
            'sent_at' => 'Sent At',
            'created_at' => 'Created At',
            'hash' => 'Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationAddress()
    {
        return $this->hasOne(\app\models\NotificationAddress::className(), ['id' => 'notification_address_id']);
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
            'notification_address_id' => $this->notification_address_id,
            'percent_off' => $this->percent_off,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'set_code', $this->set_code])
            ->andFilterWhere(['like', 'sent_at', $this->sent_at])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'hash', $this->hash]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

