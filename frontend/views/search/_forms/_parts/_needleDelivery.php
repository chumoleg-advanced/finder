<div class="col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 deliveryAddressBlock">
    <?= $form->field($model, 'deliveryAddress')->textInput([
        'placeholder' => 'Укажите адрес',
        'class'       => 'form-control deliveryAddress'
    ]); ?>

    <div id="yandexMap"></div>
</div>
