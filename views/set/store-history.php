<?php
/* @var StoreSet $storeSet */
/* @var $this \yii\web\View */
use app\models\StoreSet;
use app\models\StoreSetPrice;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$set = $storeSet->legoset;
$this->title = $set->code.' '.$set->title.' history at '.$storeSet->store;
$provider = new ActiveDataProvider([
    'query' => $storeSet->getStoreSetPrices()
]);
?>

<h1><?= Html::a($set->code.' '.$set->title, ['set/view', 'code' => $set->code]) ?></h1>
<p>Price history at <strong><?= $storeSet->store ?></strong></p>

<div class="row">
    <div class="col-md-6">
        <?= GridView::widget([
            'dataProvider' => $provider,
            'layout' => "{items}",
            'columns' => [
                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                    'label' => 'First Found',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'datetime',
                    'label' => 'Last Found',
                    'enableSorting' => false,
                ],
                [
                    'attribute' => 'price',
                    'format' => 'currency',
                    'enableSorting' => false,
                ]
            ]
        ]);
        ?>
    </div>
</div>
