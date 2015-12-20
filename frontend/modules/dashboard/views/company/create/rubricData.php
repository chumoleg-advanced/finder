<?php
use yii\widgets\ActiveForm;
use common\models\company\CompanyTypePayment;

$this->title = 'Сфера деятельности';

echo $this->render('_wizardMenu', ['event' => $event]);

$rubrics = \common\models\rubric\Rubric::findAllByCategory(1);
$rubrics = \yii\helpers\ArrayHelper::map($rubrics, 'id', 'name');

$form = ActiveForm::begin();
echo $form->field($model, 'typePayment', ['options' => ['class' => 'checkBoxButtonFormGroup']])
    ->checkboxList(CompanyTypePayment::getTypeList());

echo $form->field($model, 'typeDelivery', ['options' => ['class' => 'checkBoxButtonFormGroup']])
    ->checkboxList(CompanyTypePayment::getTypeList());

echo $form->field($model, 'rubrics', ['options' => ['class' => 'checkBoxButtonFormGroup']])
    ->checkboxList($rubrics);

echo $this->render('_buttons');
ActiveForm::end();
