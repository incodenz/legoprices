<?php

use yii\helpers\Html;
use app\models\User;

/**
* @var yii\web\View $this
* @var app\models\User $model
*/

$this->title = sprintf('Update %s: %s', User::label(), $model->__toString());
$this->params['breadcrumbs'][] = ['label' => User::label(2), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->__toString();
?>
<div class=user-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
