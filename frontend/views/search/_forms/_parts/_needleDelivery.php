<div class="col-md-12">
    <?= $form->field($model, 'delivery')->checkbox(['class' => 'showDeliveryAddress']); ?>
</div>
<div class="col-md-12 deliveryAddress">
    <?= $form->field($model, 'deliveryAddress')->textInput(
        ['class' => 'form-control', 'placeholder' => 'Укажите адрес']); ?>
</div>