<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;

$this->title = 'CBS 2016 - Registration';

?>

<h1><?= $this->title ?></h1>

<p class="lead">
    16th and 17th of July 2015, 9-5pm &mdash; Horncastle Arena.
</p>

<strong>Please fill in this form to:</strong>

<ul>
    <li>Apply to exhibiting model/s or display/s at the show.

    <li>Offer your time as a Show Volunteer

    <li>Apply to sell new or used Lego, or other miscellaneous Lego-related items at the Show (All sellers are required to donate 5% of their total turnover, payable by July 31st). This does not include GST registered companies, who are considered professional sellers and must request consideration.

    <li>Apply to come along to the social dinner on the Friday evening (<strong>??</strong>th July - Attendees are required to pay for their own meal).

    <li>Apply to come along to the AFOL event and prize ceremony directly after the show on Saturday evening (Event starting at 6:00pm, food provided from 5.15).
</ul>

<p>
    Please note that there is a registration fee of $10 per person,
    which includes the t-shirt and show bag.
    Registration fees need to be paid by <strong>Someday, 11th Month</strong>.
    Submissions are able to be changed edited after completion.
    If you have any problems or questions, please email info@LUG4x2.org.
    Registrations and edits close midnight <strong>Someday, 11th Month</strong>.
</p>

<div class="row">
    <div class="col-xs-offset-3 col-xs-3 text-right">

        <?= Html::a('Start New Registration', ['start'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class=" col-xs-3 text-left">
        <?= Html::a('Edit Previous Registration', ['continue'], ['class' => 'btn btn-default']) ?>
    </div>
</div>
