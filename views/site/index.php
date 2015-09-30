<?php
/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel app\models\LegoSetSearch */
use app\models\LegoSet;
use app\models\Theme;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <?php \yii\widgets\Pjax::begin() ?>
    <?= GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'theme_id',
                'filter' => \yii\helpers\ArrayHelper::map(Theme::find()->orderBy('description')->all(), 'id', 'description'),
                'label' => 'Theme',
                'value' => function ($m) { return $m->theme; }
            ],
            [
                'attribute' => 'code',
                'value' => function ($m) { return Html::a($m->code, ['set/view', 'code' => $m->code]); },
                'format' => 'html',
            ],
            [
                'attribute' => 'title',
                'value' => function ($m) { return Html::a($m->title, ['set/view', 'code' => $m->code]); },
                'format' => 'html',
            ],
            [
                'attribute' => 'price',
                'format' => 'currency',
                'label' => 'Best Price',
            ]
        ],
    ]) ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
