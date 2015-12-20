<?php
use yii\widgets\ActiveForm;

$this->title = 'Контактные данные';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = ActiveForm::begin();
echo $form->field($model, 'address');

echo $this->render('_buttons', ['visibleNext' => false, 'visibleDone' => true]);

ActiveForm::end();
