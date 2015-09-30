<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
* UserSearch represents the model behind the search form about `app\models\User`.
*/
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'role_id'], 'integer'],
            [['email', 'first_name', 'last_name', 'auth_key', 'password_hash', 'password_reset_token', 'password_reset_token_created', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
}