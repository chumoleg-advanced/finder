<?php
use common\models\company\CompanyTypePayment;

echo $form->field($model, 'typePayment', [
    'template' => "{label}\n{input}",
    'options'  => ['class' => 'checkBoxButtonFormGroup']
])->checkboxList(CompanyTypePayment::getTypeList());