<?php
/**
 * @var LegoSet $model
 */
use app\models\LegoSet;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = $model->code.' '.$model->title;
$provider = new ActiveDataProvider([
    'query' => $model->getStoreSets()
]);
?>

<h1><?= $model->code.' '.$model->title ?></h1>
<strong>Year</strong> <?= $model->year ?><br />
<strong>Theme</strong> <?= $model->theme ?><br />
<strong>RRP</strong> <?= $model->rrp ? Yii::$app->formatter->asCurrency($model->rrp) : '?' ?><br />
<br />

<div class="row">
    <div class="col-md-6">
        <?= GridView::widget([
            'dataProvider' => $provider,
            'layout' => "{items}",
            'columns' => [
                [
                    'attribute' => 'store_id',
                    'label' => 'Store',
                    'value' => function ($m) { return Html::a($m->store->title, $m->url); },
                    'format' => 'html',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'price',
                    'contentOptions' => ['class' => 'text-right'],
                    'value' => function ($m) use ($model) {
                        return $model->rrp && $m->price < $model->rrp
                            ? '<strong style="color:red;">'.Yii::$app->formatter->asCurrency($m->price).'</strong>'
                            : Yii::$app->formatter->asCurrency($m->price);
                    },
                    'format' => 'html',
                ]
            ]
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?= Html::a(Html::img($model->thumbnail_url), $model->brickset_url) ?>
    </div>
</div>

