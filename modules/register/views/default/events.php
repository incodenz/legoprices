<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */

use yii\helpers\Html;

$this->title = 'CBS 2016 - Events';

?>
<div class="register events">

    <h1>Events</h1>
    <p class="lead">For 2016 we have some great events we are running during the show that you can signup for.</p>

    <?php if (!$model->isPaid()) { ?>
        <div class="alert alert-warning" style="color: #000;">
            <strong>Sorry</strong>
            <p>We don't have a record of you paying yet.
                If you have paid by bank transfer it might take a few days to show up.
            </p>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-md-4">
        </div>
    </div>
</div>
