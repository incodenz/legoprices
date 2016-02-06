<?php
/* @var $this \yii\web\View */

use app\modules\register\models\Registration;
use yii\helpers\Html;
use yii\helpers\Url;

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

    <li>Apply to sell new or used Lego, or other miscellaneous Lego-related items at the Show (All sellers are required to pay a larger <?= Html::a('fee', ['fees']) ?>).

    <li>Expression of interest for the social dinner on the Friday evening (Attendees are required to pay for their own meal).

    <li>Apply to come along to the AFOL event and <?= Html::a('prize ceremony', ['prizes']) ?> directly after the show on Saturday evening (Event starting at 6:00pm, food provided from 5.15).

    <li>Purchase the exclusive <a href="<?= Url::to(['set']) ?>">"Christchurch Railway Station"</a> only available for purchase during registration at <?= Yii::$app->formatter->asCurrency(Registration::SHOW_SET_FEE) ?>.</li>
</ul>

<p>
    Registrations are <?= Yii::$app->formatter->asCurrency(Registration::REGISTRATION_FEE) ?> for 1st person and
    <?= Yii::$app->formatter->asCurrency(Registration::ADDITIONAL_FEE) ?> for additional members of group (View all <?= Html::a('fees and charges', ['fees']) ?>).
    Fee payable upon registration.
    Registrations and edits close on 20th April
    which includes the t-shirt and show bag.
    Registrations and changes close midnight <strong>Wednesday, 20th April</strong>, all registration fees must also be paid by the close off date.
    Submissions are able to be changed edited after completion.
    If you have any problems or questions, please email <a href="mailto:info@LUG4x2.org">info@LUG4x2.org</a>.
</p>

<div class="row">
    <div class="col-xs-offset-3 col-xs-3 text-right">

        <?= Html::a('Start New Registration', ['start'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class=" col-xs-3 text-left">
        <?= Html::a('Edit Previous Registration', ['continue'], ['class' => 'btn btn-default']) ?>
    </div>
</div>
