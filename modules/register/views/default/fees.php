<?php
/* @var $this \yii\web\View */

use app\modules\register\models\Registration;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'CBS 2016 - Fees & Charges';

?>

<h1><?= $this->title ?></h1>

<p class="lead">
    16th and 17th of July 2015, 9-5pm &mdash; Horncastle Arena.
</p>

<table class="table">
    <tr>
        <th colspan="3" class="text-center">Registration Fees</th>
    </tr>
    <tr>
        <th>Registration Fee</th>
        <td class="text-right"><?= Yii::$app->formatter->asCurrency(Registration::REGISTRATION_FEE) ?></td>
        <td></td>
    </tr>
    <tr>
        <th>Additional group members</th>
        <td class="text-right"><?= Yii::$app->formatter->asCurrency(Registration::ADDITIONAL_FEE) ?></td>
        <td>(per member)</td>
    </tr>
    <tr>
        <th><a href="<?= Url::to(['set']) ?>">"Christchurch Railway Station"</a> - Exclusive "Registration Only" Set</th>
        <td class="text-right"><?= Yii::$app->formatter->asCurrency(Registration::SHOW_SET_FEE) ?></td>
        <td></td>
    </tr>
    <tr></tr>
    <tr>
        <th colspan="3" class="text-center">Seller Fees</th>
    </tr>
    <tr>
        <th>Small Seller <a href="#nb">*</a></th>
        <td class="text-right"><?= Yii::$app->formatter->asCurrency(Registration::SALES_TABLE_FEE) ?></td>
        <td>(per table)</td>
    </tr>
    <tr>
        <th>Professional Sellers <a href="#nb">*</a></th>
        <td colspan="2" class="text-center">please email <a href="mailto:<?= Registration::EMAIL ?>"><?= Registration::EMAIL ?></a></td>
    </tr>
</table>

<p name="nb"><strong>*</strong>
    Any seller table deposit is deemed to be confirmed and accepted only after being accepted by the CBS committee.
    Any seller in the business of selling (with a physical or internet presence determined by the CBS committee) will be treated
    as a professional seller and fall under a separate rate. Please email <a href="mailto:<?= Registration::EMAIL ?>"><?= Registration::EMAIL ?></a>
    for more information

</p>

<p>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
</p>