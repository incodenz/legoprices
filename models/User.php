<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


class User extends base\User implements \yii\web\IdentityInterface
{
    const ROLE_AGENT = 10;
    const ROLE_ADMIN = 20;
    const ROLE_MASTER = 30;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 20;

    public $password;

    private static $_statuses = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DELETED => 'Deleted',
    ];

    private static $_roles = [
        self::ROLE_AGENT => 'Agent',
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_MASTER => 'Master',
    ];


    /**
     * String representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        $names = array_filter([$this->first_name, $this->last_name]);
        return implode(' ', $names);
    }

    /**
     * Return an array of User statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return self::$_statuses;
    }

    /**
     * Return the label of the current user status
     *
     * @return String
     */
    public function getStatus()
    {
        return self::$_statuses[$this->status_id];
    }

    /**
     * Return an array of all user roles
     *
     * @return array
     */
    public static function getRoles()
    {
        $roles = self::$_roles;
        if (Yii::$app->user->identity->role_id != self::ROLE_MASTER) {
            unset($roles[self::ROLE_MASTER]);
        }
        return $roles;
    }

    /**
     * Return the label of the assigned role.
     *
     * @return String
     */
    public function getRole()
    {
        return self::$_roles[$this->role_id];
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();

        return ArrayHelper::merge($rules, [
            ['status_id', 'default', 'value' => self::STATUS_ACTIVE],
            ['role_id', 'default', 'value' => self::ROLE_AGENT],
            ['password', 'string'],
            ['status_id', 'in', 'range' => array_keys(self::$_statuses)],
            ['role_id', 'in', 'range' => array_keys(self::$_roles)],
            ['role_id', 'validateRole'],
            [['last_name', 'mobile_number'], 'required'],
        ]);
    }

    public function validateRole() {
        if (Yii::$app->user->identity->role_id === self::ROLE_MASTER) {
            return;
        }
        if ($this->oldAttributes['role_id'] == self::ROLE_MASTER || $this->role_id == self::ROLE_MASTER) {
            $this->addError('id', 'Unable to update '.$this.', insufficient permissions');
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['access_token' => $token, 'status_id' => self::STATUS_ACTIVE])->one();
    }

    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return null|\app\models\User
     */
    public static function findByPasswordResetToken($token)
    {
        $user = User::findOne([
            'password_reset_token' => $token,
            'status_id' => User::STATUS_ACTIVE,
        ]);

        if (!$user || !$user->isPasswordResetTokenValid()) {
            return null;
        }

        return $user;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @return boolean
     */
    public function isPasswordResetTokenValid()
    {
        if (empty($this->password_reset_token)) {
            return false;
        }

        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        $expireDate = strtotime(
            sprintf('+%s Minutes', $expire),
            strtotime($this->password_reset_token_created)
        );

        return (time() <= $expireDate);
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token_created = new Expression('CURRENT_TIMESTAMP');
        $this->password_reset_token = Yii::$app->security->generateRandomString();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        $this->password_reset_token_created = null;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
        }

        if ($this->password) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'role_id' => 'Role',
                'status_id' => 'Status',
            ]
        );
    }


}
