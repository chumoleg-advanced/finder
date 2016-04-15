<?php 

use kartik\switchinput\SwitchInput;

?>

<?php
frontend\assets\YandexMapAsset::register($this);
?>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
    </div>
</div>

<div class="form-group deliveryAddressBlock">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, 'deliveryAddress')->textInput([
            'placeholder' => 'Укажите адрес',
            'class'       => 'form-control deliveryAddress'
        ]); ?>

        <div id="yandexMap"></div>
    </div>

    <?= $form->field($model, 'addressCoordinates')->hiddenInput(['class' => 'addressCoordinates']); ?>
</div>
