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

$this->title = $model;
$provider = new ActiveDataProvider([
    'query' => $model->getStoreSets()
]);
?>

<h1><?= $model ?></h1>
<strong>Year</strong> <?= Html::a($model->year, '/?LegoSetSearch%5Byear%5D='.$model->year) ?><br />
<strong>Theme</strong> <?= Html::a($model->theme, '/?LegoSetSearch%5Btheme_id%5D='.$model->theme_id) ?><br />
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
                                $m->currentPrice &&
                                $m->currentPrice->status_id == StoreSetPrice::STATUS_OUT_OF_STOCK
                                    ? '<strong class="text-muted"><em> (Out of Stock)</em></strong>'
                                    : ''
                            ).' '.
                            Html::a('(history)', ['set/store-history', 'id' => $m->id], ['class' => 'small text-muted']);
                    },
                    'format' => 'html',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'price',
                    'contentOptions' => ['class' => 'text-right'],
                    'value' => function ($m) use ($model) {
                        if (!$m->price) {
                            return '';
                        }
                        /* @var app\models\StoreSet $m */
                        $price = Yii::$app->formatter->asCurrency($m->price);
                        if ($m->currentPrice && $m->currentPrice->status_id == StoreSetPrice::STATUS_OUT_OF_STOCK) {
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
        <div class="well">
            <?= $this->render('/notify/_set', [
                'model' => $model,
                'notifySet' => $notifySet,
                'notifyAddress' => $notifyAddress,
                'notifySuccess' => $notifySuccess,
            ]); ?>

        </div>
    </div>
    <div class="col-md-6 text-center">
        <?= Html::a(Html::img($model->thumbnail_url), $model->brickset_url) ?>
    </div>
</div>
