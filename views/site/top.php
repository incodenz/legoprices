<?php
/**
 * lego - Created by brucealdridge at 2/10/15 17:37
 */
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Top Deals';
$legoSet = new \app\models\LegoSet();
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'layout' => "{items}",
    'columns' => [
        [
            'attribute' => 'code',
            'label' => $legoSet->getAttributeLabel('code'),
            'value' => function ($m) {
                return Html::a($m['code'], ['set/view', 'code' => $m['code']]);
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'rrp',
            'label' => 'RRP',
            'format' => 'currency',
            'contentOptions' => ['class' => 'text-right'],
        ],
        [
            'attribute' => 'price',
            'label' => 'Price',
            'format' => 'currency',
            'contentOptions' => ['class' => 'text-right'],
        ],
        [
            'attribute' => 'discount',
            'label' => 'Discount %',
            'contentOptions' => ['class' => 'text-right'],
            'value' => function ($m) {
                return round($m['discount']).'%';
            }
        ],
        [
            'attribute' => 'discount',
            'label' => 'Discount $',
            'contentOptions' => ['class' => 'text-right'],
            'value' => function ($m) {
                return Yii::$app->formatter->asCurrency($m['rrp'] - $m['price']);
            }
        ],

    ]
]);
