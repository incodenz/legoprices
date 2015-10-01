<?php
/**
 * @var LegoSet $model
 */
/* @var NotificationAddress $notifyAddress */
/* @var NotificationSet $notifySet */
/* @var bool $notifySuccess */
/* @var $this \yii\web\View */
use app\models\LegoSet;
use app\models\StoreSetPrice;
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
                    'value' => function ($m) {
                        /* @var app\models\StoreSet $m */
                        return Html::a($m->store->title, $m->url) .
                            (
                                $m->currentPrice->status_id == StoreSetPrice::STATUS_OUT_OF_STOCK
                                    ? '<strong class="text-muted"><em> (Out of Stock)</em></strong>'
                                    : ''
                            );
                    },
                    'format' => 'html',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'price',
                    'contentOptions' => ['class' => 'text-right'],
                    'value' => function ($m) use ($model) {
                        /* @var app\models\StoreSet $m */
                        $price = Yii::$app->formatter->asCurrency($m->price);
                        if ($m->currentPrice->status_id == StoreSetPrice::STATUS_OUT_OF_STOCK) {
                            return '<span class="text-muted">'.$price.'</span>';
                        }
                        return $model->rrp && $m->price < $model->rrp
                            ? '<strong style="color:red;">'.$price.'</strong>'
                            : $price;
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

<?= $this->render('/notify/_set', [
    'model' => $model,
    'notifySet' => $notifySet,
    'notifyAddress' => $notifyAddress,
    'notifySuccess' => $notifySuccess,
]);