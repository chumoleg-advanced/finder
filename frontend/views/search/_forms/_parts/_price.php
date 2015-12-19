<?php
use common\components\ActiveField;

?>

<div class="form-group">
    <div class="col-md-offset-2 col-md-5 col-sm-7 col-xs-12">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'priceFrom')->textInput(['placeholder' => 'Цена от']); ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'priceTo', ActiveField::getHintProperties())
                ->textInput(['placeholder' => 'до'])->hint('Введите стоимость товара.'); ?>
        </div>
    </div>
</div>