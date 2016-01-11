<?php
use common\models\company\CompanyTypeDelivery;

echo $form->field($model, 'typeDelivery', [
    'template' => "{label}\n{input}",
    'options'  => ['class' => 'checkBoxButtonFormGroup']
])->checkboxList(CompanyTypeDelivery::getTypeList());