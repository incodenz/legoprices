<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "theme".
 *
 * @property integer $id
 * @property string $description
 *
 * @property \app\models\LegoSet[] $legoSets
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Theme} other{Themes}}', ['n' => $n]);
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
            [['description'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLegoSets()
    {
        return $this->hasMany(\app\models\LegoSet::className(), ['theme_id' => 'id']);
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
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

