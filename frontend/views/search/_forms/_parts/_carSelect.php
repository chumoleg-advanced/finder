<?php
use \kartik\widgets\Select2;
?>

<div class="col-md-3">
    <?= $form->field($model, 'carFirm')->widget(Select2::classname(), [
        'data'          => $carFirms,
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('carFirm'),
            'class'       => 'carFirmSelect'
        ]
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'carModel')->widget(Select2::classname(), [
        'data'          => [],
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('carModel'),
            'class'       => 'carModelSelect'
        ]
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'carBody')->widget(Select2::classname(), [
        'data'          => [],
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('carBody'),
            'class'       => 'carBodySelect'
        ]
    ]); ?>
</div>
<div class="col-md-3">
    <?= $form->field($model, 'carEngine')->widget(Select2::classname(), [
        'data'          => [],
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('carEngine'),
            'class'       => 'carEngine'
        ]
    ]); ?>
</div>