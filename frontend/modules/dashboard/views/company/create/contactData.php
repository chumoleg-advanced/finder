<?php
use yii\widgets\ActiveForm;

$this->title = 'Registration Wizard';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = ActiveForm::begin();
echo $form->field($model, 'street_address');
echo $form->field($model, 'locality');
echo $form->field($model, 'region');
echo $form->field($model, 'postal_code');

echo $this->render('_buttons', ['visibleNext' => false, 'visibleDone' => true]);

ActiveForm::end();
