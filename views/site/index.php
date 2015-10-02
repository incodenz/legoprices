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

    <?= GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'theme_id',
                'filter' => \yii\helpers\ArrayHelper::map(Theme::find()->orderBy('description')->all(), 'id', 'description'),
                'label' => 'Theme',
                'headerOptions' => ['class' => 'col-md-3'],
                'value' => function ($m) { return $m->theme; }
            ],
            [
                'attribute' => 'code',
                'headerOptions' => ['class' => 'col-md-1'],
                'value' => function ($m) { return Html::a($m->code, ['set/view', 'code' => $m->code]); },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'title',
                'value' => function ($m) {
                    return Html::a($m->title, ['set/view', 'code' => $m->code]).
                        (
                        $m->rrp && $m->price < $m->rrp
                            ? ' - <em>'.round(($m->rrp-$m->price) / $m->rrp * 100).'% off</em>'
                            : ''
                        )
                        ;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'year',
                'headerOptions' => ['class' => 'col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'price',
                'label' => 'Best Price',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function ($m) {
                    return $m->rrp && $m->price < $m->rrp
                        ? '<strong style="color:red;">'.
                            Yii::$app->formatter->asCurrency($m->price).
                            '</strong>'
                        : Yii::$app->formatter->asCurrency($m->price);
                },
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
