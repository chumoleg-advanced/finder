<?php
use yii\widgets\ActiveForm;

$this->title = 'Registration Wizard';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = ActiveForm::begin();
echo $form->field($model, 'value');
echo $form->field($model, 'type')->radiolist([
    'Home'   => 'Home',
    'Mobile' => 'Mobile',
    'Work'   => 'Work'
]);
echo $this->render('_buttons');
ActiveForm::end();
