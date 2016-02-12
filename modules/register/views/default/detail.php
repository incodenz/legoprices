<?php
/* @var $this \yii\web\View */
/* @var $model app\modules\register\models\Registration */

use app\modules\register\models\Registration;use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'CBS 2016 - Registration';

?>
<div class="register register-detail">

    <?php $form = ActiveForm::begin([
            'id'     => 'Team',
            'layout' => 'horizontal',
            'enableClientValidation' => false,
        ]
    ); ?>

    <?php
    echo $form->errorSummary(array_merge([$model], $model->registrationTeamMembers)); ?>

    <fieldset>
        <?php if ($model->type_id != Registration::TYPE_VOLUNTEER) { ?>
        <legend>Table Requirements</legend>


            <?php if (in_array($model->type_id, [Registration::TYPE_EXHIBIT, Registration::TYPE_BOTH])) { ?>
                <?= $form->field($model, 'display_tables')->dropDownList(array_combine(Registration::getDisplayTables(), Registration::getDisplayTables())) ?>
            <?php } ?>
            <?php if (in_array($model->type_id, [Registration::TYPE_SALES, Registration::TYPE_BOTH])) { ?>
                <?= $form->field($model, 'sales_tables')->dropDownList(array_combine(Registration::getSalesTables(), Registration::getSalesTables())) ?>
                <p class=small>NB. sales tables are charged at <?= Yii::$app->formatter->asCurrency(Registration::SALES_TABLE_FEE) ?> per table for small sellers.
                    See <?= Html::a('fees and charges', ['fees'], ['target' => '_blank']) ?> for more information
                </p>
            <?php } ?>

            <?php if (in_array($model->type_id, [Registration::TYPE_SALES, Registration::TYPE_BOTH, Registration::TYPE_EXHIBIT])) { ?>
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <p class="small">See <a href="/tables.png" target="_blank">table layouts</a> for more details</p>
                    </div>
                </div>
            <?php } ?>


            <?= $form->field($model, 'exhibit_details')->textarea() ?>
            <?= $form->field($model, 'travel_grant')->textarea() ?>
               <div class="row">
                    <div class="col-sm-9 col-sm-offset-3">
                        <p class="small">
                            If required please give tell us what you need a grant for and how you intend to use it.
                            Final decision on allocation of grants and amounts given are at the discretion of the CBS2016 committee.
                        </p>
                    </div>
                </div>
            <?= $form->field($model, 'power_required')->checkbox() ?>


            <?= $form->field($model, 'collab_city')->checkbox() ?>
            <?= $form->field($model, 'collab_moonbase')->checkbox() ?>
            <?= $form->field($model, 'collab_gbc')->checkbox() ?>
            <?= $form->field($model, 'collab_glowindark')->checkbox() ?>
        <?php } ?>
        <?= $form->field($model, 'terms')->checkbox()->label('I agree to the terms and conditions') ?>
    </fieldset>

    <?php foreach($model->registrationTeamMembers as $k => $registrationTeamMember) { ?>
    <fieldset>
        <legend>
            <?= count($model->registrationTeamMembers) == 1 ? 'Your Details' : 'Team Member #'.($k + 1) ?>
            <?= $registrationTeamMember->primary_contact ? '' : Html::submitButton(
                'Delete Team Member',
                [
                    'class' => 'btn btn-link btn-xs pull-right',
                    'name' => 'removeMember',
                    'value' => $registrationTeamMember->id
                ]
            ) ?>
        </legend>
        <!-- <p>If you enter a email address we'll send them an email with a link to confirm their details</p> -->
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']first_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']last_name')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']email')->textInput() ?>

        <?php if (!$registrationTeamMember->primary_contact) { ?>
            <!-- <?= $form
                ->field($registrationTeamMember, '['.$registrationTeamMember->id.']email_me')
                ->checkbox(['class' => 'hide-extra'])
                ->label('Email this Team Member so they can fill in their own details')
            ?> -->

        <div class="extra-fields">
        <?php } ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']contact_number')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']address')->textarea() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']over_18')->checkbox(['class' => 'over18-check']) ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']parental_consent', ['options' => ['class' => 'form-group over18-not']])->checkbox()->label('Parental consent given') ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']option_afol')->checkbox(['class' => 'dinner-check']) ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']emergency_contact')->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']dietary_requirements', ['options' => ['class' => 'form-group dinner-only']])->textInput() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']hivis')->checkbox() ?>
        <?= $form->field($registrationTeamMember, '['.$registrationTeamMember->id.']show_set')->checkbox() ?>
            <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
            <p class="small">NB. <a href="<?= Url::to(['set']) ?>" target="_blank">"Christchurch Railway Station"</a> - exclusive registration only set is an additional <?= Yii::$app->formatter->asCurrency(Registration::SHOW_SET_FEE) ?> per set.
                See <?= Html::a('fees and charges', ['fees'], ['target' => '_blank']) ?> for more information
            </p>
                </div>
            </div>

        <?= $form
            ->field($registrationTeamMember, '['.$registrationTeamMember->id.']tshirt_size')
            ->dropDownList(
                \app\modules\register\models\RegistrationTeamMember::shirtSizes(),
                [
                    'prompt' => '',
                ]
            ) ?>
        <?= $form
            ->field($registrationTeamMember, '['.$registrationTeamMember->id.']tshirt_colour')
            ->dropDownList(
                \app\modules\register\models\RegistrationTeamMember::shirtColours($model),
                [
                    'prompt' => '',
                ]
            ) ?>
        <?php if (!$registrationTeamMember->primary_contact) { ?>
        </div> <!-- // .hide-extra -->
        <?php } ?>
    </fieldset>
    <?php } ?>
    <hr />
    <div class="pull-left">
        <?= Html::submitButton(
            'Add New Team Member',
            [
                'class' => 'btn btn-default btn-xs',
                'name' => 'addMember',
                'value' => 'addMember'
            ]
        ) ?>
<br />
        <p class="small">NB. Additional members are charged at <?= Yii::$app->formatter->asCurrency(Registration::ADDITIONAL_FEE) ?> per member.
            See <?= Html::a('fees and charges', ['fees'], ['target' => '_blank']) ?> for more information
        </p>
    </div>
    <div class="pull-right">
        <?= Html::submitButton('Save', [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-primary'
        ]); ?>
    </div>
    <?php ActiveForm::end() ?>


</div>
<?php

$js = <<<JS
$('.over18-check').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.over18-only').show();
        $(this).parents('fieldset').find('.over18-not').hide();
    } else {
        $(this).parents('fieldset').find('.over18-only').hide();
        $(this).parents('fieldset').find('.over18-not').show();
    }
}).change();
$('.dinner-check').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.dinner-only').show();
        $(this).parents('fieldset').find('.dinner-not').hide();
    } else {
        $(this).parents('fieldset').find('.dinner-only').hide();
        $(this).parents('fieldset').find('.dinner-not').show();
    }
}).change();
$('.hide-extra').change(function () {
    if (this.checked) {
        $(this).parents('fieldset').find('.extra-fields').slideUp();
    } else {
        $(this).parents('fieldset').find('.extra-fields').slideDown();
    }
}).change()

JS;

$this->registerJs($js);