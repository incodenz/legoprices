<?php

namespace app\modules\register\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "registration".
 *
 * @property integer $id
 * @property integer $status_id
 * @property integer $type_id
 * @property string $exhibit_details
 * @property string $display_tables
 * @property integer $power_required
 * @property string $travel_grant
 * @property integer $terms
 * @property string $comments
 * @property string $created_at
 * @property string $updated_at
 * @property string $collab_city
 * @property string $collab_moonbase
 * @property string $collab_gbc
 * @property string $collab_glowindark
 * @property string $sales_tables
 *
 * @property \app\modules\register\models\RegistrationTeamMember[] $registrationTeamMembers
 */
class Registration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'registration';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Registration} other{Registrations}}', ['n' => $n]);
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
            [['status_id', 'type_id', 'power_required', 'terms'], 'integer'],
            [['exhibit_details', 'display_tables', 'travel_grant', 'comments'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['collab_city', 'collab_moonbase', 'collab_gbc', 'collab_glowindark', 'sales_tables'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Status ID',
            'type_id' => 'Type ID',
            'exhibit_details' => 'Exhibit Details',
            'display_tables' => 'Display Tables',
            'power_required' => 'Power Required',
            'travel_grant' => 'Travel Grant',
            'terms' => 'Terms',
            'comments' => 'Comments',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'collab_city' => 'Collab City',
            'collab_moonbase' => 'Collab Moonbase',
            'collab_gbc' => 'Collab Gbc',
            'collab_glowindark' => 'Collab Glowindark',
            'sales_tables' => 'Sales Tables',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistrationTeamMembers()
    {
        return $this->hasMany(\app\modules\register\models\RegistrationTeamMember::className(), ['registration_id' => 'id']);
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
            'type_id' => $this->type_id,
            'power_required' => $this->power_required,
            'terms' => $this->terms,
        ]);

        $query->andFilterWhere(['like', 'exhibit_details', $this->exhibit_details])
            ->andFilterWhere(['like', 'display_tables', $this->display_tables])
            ->andFilterWhere(['like', 'travel_grant', $this->travel_grant])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'collab_city', $this->collab_city])
            ->andFilterWhere(['like', 'collab_moonbase', $this->collab_moonbase])
            ->andFilterWhere(['like', 'collab_gbc', $this->collab_gbc])
            ->andFilterWhere(['like', 'collab_glowindark', $this->collab_glowindark])
            ->andFilterWhere(['like', 'sales_tables', $this->sales_tables]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

