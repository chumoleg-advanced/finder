<?php

use common\models\city\City;

echo $form->field($model, 'city_id')->dropDownList(City::getList());
echo $form->field($model, 'address')->textInput(['class' => 'form-control deliveryAddress']);
echo $form->field($model, 'addressCoordinates', ['template' => '{input}'])
    ->hiddenInput(['class' => 'addressCoordinates']);