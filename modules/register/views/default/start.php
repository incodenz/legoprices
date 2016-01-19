<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */
/* @var $primaryContact app\modules\register\models\RegistrationTeamMember */

use app\modules\register\models\Registration;use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'CBS 2016 - Registration';

?>

<h1><?= $this->title ?></h1>
<div class="registration registration-new">
    <?php $form = ActiveForm::begin([
            'id'     => 'Team',
            'layout' => 'horizontal',
            'enableClientValidation' => false,
        ]
    ); ?>

    <?php echo $form->errorSummary([$model, $primaryContact]); ?>

    <fieldset>
        <legend>Your Details</legend>
        <?= $form->field($primaryContact, 'first_name')->textInput() ?>
        <?= $form->field($primaryContact, 'last_name')->textInput() ?>
        <?= $form->field($primaryContact, 'email')->textInput() ?>
        <?= $form->field($model, 'type_id')->dropDownList(Registration::getTypes()) ?>
    </fieldset>


<!--
    <fieldset>
        <legend>Table Requirements</legend>
        <?= $form->field($model, 'type_id')->dropDownList(Registration::getTypes()) ?>
        <?= $form->field($model, 'table_size')->dropDownList(array_combine(Registration::getTables(), Registration::getTables())) ?>
        <?= $form->field($model, 'power_required')->checkbox() ?>
        <?= $form->field($model, 'travel_grant')->textarea() ?>
        <?= $form->field($model, 'terms')->checkbox()->label('I agree to the terms and conditions') ?>
    </fieldset> -->

    <fieldset class="team_members">
        <?= $form->field($model, 'team_members')->dropDownList([
                '0' => '0 - It\'ll just be me',
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
            ]
        )->hint('Registration costs '.Registration::FEE.' per person') ?>
    </fieldset>
    <hr/>

    <div class="pull-right">
    <?= Html::submitButton('Create Registration', [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-primary'
    ]); ?>
    </div>

    <?php ActiveForm::end() ?>
</div>

<?php

$type_id = Json::encode('#'.Html::getInputId($model, 'type_id'));
$volunteer = Json::encode(Registration::TYPE_VOLUNTEER);
$js = <<<JS
$({$type_id}).change(function () {
    if ($(this).val() == {$volunteer}) {
        $('.team_members').val(0).hide();
    } else {
        $('.team_members').show();
    }
}).change();
JS;
$this->registerJs($js);

//$tableId = Json::encode('#'.Html::getInputId($model, 'table_size'));
//$tableOptions = Json::encode(Registration::getTables());
$js = <<<JS
function updateButtons() {
    var members = $('.team_member').length,
        devide = $('.btn-devide'),
        multiply = $('.btn-multiply');

    if (members > 1) {
        devide.show();
    } else {
        devide.hide();
    }
    if (members > 10) {
        multiply.hide();
    } else {
        multiply.show();
    }
}
updateButtons();
$('.btn-multiply').click(function (e) {
    e.preventDefault();
    var members = $('.team_member').length,
        original = $('.team_member').eq(0),
        container = $('.team_members'),
        child = original.clone();

    child.find('input').each(function () {
        $(this).attr('name', $(this).attr('name').replace('[0]', '['+members+']'));
        $(this).attr('id', $(this).attr('id').replace('-0-', '-'+members+'-'));
        $(this).val('');
    }).end().appendTo(container);

    updateButtons();
});
$('.btn-devide').click(function (e) {
    e.preventDefault();
    var members = $('.team_member').length,
        last = $('.team_member').filter(':last');

    if (members <= 1) {
        return;
    }
    last.remove();

    updateButtons();
});
JS;
/*
$({$tableId}).parent().selectOther({
    items: {$tableOptions},
    selectClass: 'form-control'
});*/
//$this->registerJsFile('@web/select-other.js', ['depends' => \app\assets\AppAsset::className()]);
//$this->registerJs($js);
