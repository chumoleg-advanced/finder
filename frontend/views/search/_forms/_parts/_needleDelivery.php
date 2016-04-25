<?php 

use kartik\switchinput\SwitchInput;

?>

<?php
frontend\assets\YandexMapAsset::register($this);
?>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, '[0]delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
    </div>
</div>

<div class="form-group deliveryAddressBlock">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, '[0]deliveryAddress')->textInput([
            'placeholder' => 'Укажите адрес',
            'class'       => 'form-control deliveryAddress'
        ]); ?>

        <div class="yandexMap" id="yandexMap_0"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, '[0]addressCoordinates')->hiddenInput(['class' => 'addressCoordinates']); ?>
    </div>
</div>
