<?php

use yii\helpers\Html;
use app\models\User;

/**
* @var yii\web\View $this
* @var app\models\User $model
*/

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => User::label(2), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
