<?php
\app\assets\YandexMapAsset::register($this);
?>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <hr/>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
        </div>
    </div>
</div>

<div class="form-group deliveryAddressBlock">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <?= $form->field($model, 'deliveryAddress')->textInput([
                'placeholder' => 'Укажите адрес',
                'class'       => 'form-control deliveryAddress'
            ]); ?>

            <div id="yandexMap"></div>
        </div>
    </div>
</div>
