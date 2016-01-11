<?php
/** @var \kartik\form\ActiveForm $form */

use frontend\modules\dashboard\forms\company\MainData;

echo $form->field($model, 'form', ['options' => ['class' => 'form-group radioButtonFormGroup']])
    ->radioButtonGroup(MainData::getFormList(), [
        'class'       => 'btn-group companyFormGroup',
        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
    ]);

echo $form->field($model, 'legal_name', ['options' => ['class' => 'form-group legalNameForm']])
    ->textInput(['maxlength' => 250]);
echo $form->field($model, 'actual_name', ['options' => ['class' => 'form-group actualNameForm']])
    ->textInput(['maxlength' => 250]);
echo $form->field($model, 'fio', ['options' => ['class' => 'form-group fioForm']])
    ->textInput(['maxlength' => 250]);
echo $form->field($model, 'inn', ['options' => ['class' => 'form-group innForm']])
    ->textInput(['maxlength' => 12]);
echo $form->field($model, 'ogrn', ['options' => ['class' => 'form-group ogrnForm']])
    ->textInput(['maxlength' => 15]);
echo $form->field($model, 'ogrnip', ['options' => ['class' => 'form-group ogrnipForm']])
    ->textInput(['maxlength' => 15]);