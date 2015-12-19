<?php
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Registration Wizard';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = ActiveForm::begin();
echo $form->field($model, 'honorific_prefix')->dropDownList([
    'Mr'  => 'Mr',
    'Mrs' => 'Mrs',
    'Ms'  => 'Ms'
]);

echo $form->field($model, 'given_name');
echo $form->field($model, 'family_name');
echo $form->field($model, 'date_of_birth')->widget(DatePicker::className(), [
    'clientOptions' => [
        'changeMonth' => true,
        'changeYear'  => true,
        'maxDate'     => 0,
        'showAnim'    => 'fade'
    ]
]);

echo $this->render('_buttons', ['visiblePrev' => false]);

ActiveForm::end();
