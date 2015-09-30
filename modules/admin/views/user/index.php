<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\admin\models\UserSearch $searchModel
 */

$this->title = app\models\User::label(2);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <div class="clearfix">
        <p class="pull-left">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'New') . ' User', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php if (Yii::$app->session->hasFlash('Customer_error')): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?=Yii::$app->session->getFlash('User_error', null, true)?>
    </div>
    <?php endif ?>
    
    <div class="table-responsive">
        <?php \yii\widgets\Pjax::begin(); ?>
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => Yii::t('app', 'First'),
                'lastPageLabel' => Yii::t('app', 'Last'),
            ],
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'value' => function ($u) {
                        return Html::a($u->email, ['update', 'id' => $u->id]);
                    }
                ],
                'status',
                'role',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['nowrap'=>'nowrap', 'class' => 'text-center'],
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
