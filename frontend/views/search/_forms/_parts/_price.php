<div class="form-group">
    <div class="col-md-offset-2 col-md-5 col-sm-7 col-xs-12">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'priceFrom')->textInput(['placeholder' => 'Цена от']); ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'priceTo')->textInput(['placeholder' => 'до']); ?>
        </div>
    </div>
</div>