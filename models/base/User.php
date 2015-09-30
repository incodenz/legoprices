<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $password_reset_token_created
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $role_id
 * @property string $last_login
 * @property integer $failed_attempts
 * @property string $password_change_date
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{User} other{Users}}', ['n' => $n]);
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
            [['email', 'first_name', 'role_id'], 'required'],
            [['password_reset_token_created', 'created_at', 'updated_at', 'last_login', 'password_change_date'], 'safe'],
            [['status_id', 'role_id', 'failed_attempts'], 'integer'],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 90],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'password_reset_token_created' => 'Password Reset Token Created',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role_id' => 'Role ID',
            'last_login' => 'Last Login',
            'failed_attempts' => 'Failed Attempts',
            'password_change_date' => 'Password Change Date',
        ];
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
            'status_id' => $this->status_id,
            'role_id' => $this->role_id,
            'failed_attempts' => $this->failed_attempts,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'password_reset_token_created', $this->password_reset_token_created])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'last_login', $this->last_login])
            ->andFilterWhere(['like', 'password_change_date', $this->password_change_date]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

