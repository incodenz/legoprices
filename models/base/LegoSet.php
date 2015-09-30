<?php

namespace app\models\base;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the base-model class for table "lego_set".
 *
 * @property integer $id
 * @property string $code
 * @property string $rrp
 * @property string $title
 * @property string $description
 * @property string $year
 * @property integer $theme_id
 * @property string $thumbnail_url
 * @property string $brickset_url
 *
 * @property \app\models\Theme $theme
 * @property \app\models\StoreSet[] $storeSets
 */
class LegoSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lego_set';
    }

    /**
     *
     */
    public static function label($n = 1)
    {
        return Yii::t('app', '{n, plural, =1{Lego Set} other{Lego Sets}}', ['n' => $n]);
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
            [['rrp'], 'number'],
            [['description'], 'string'],
            [['theme_id'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 100],
            [['year'], 'string', 'max' => 4],
            [['thumbnail_url', 'brickset_url'], 'string', 'max' => 150],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'rrp' => 'Rrp',
            'title' => 'Title',
            'description' => 'Description',
            'year' => 'Year',
            'theme_id' => 'Theme ID',
            'thumbnail_url' => 'Thumbnail Url',
            'brickset_url' => 'Brickset Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(\app\models\Theme::className(), ['id' => 'theme_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreSets()
    {
        return $this->hasMany(\app\models\StoreSet::className(), ['legoset_id' => 'id']);
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
            'rrp' => $this->rrp,
            'theme_id' => $this->theme_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'thumbnail_url', $this->thumbnail_url])
            ->andFilterWhere(['like', 'brickset_url', $this->brickset_url]);

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
    }
}

