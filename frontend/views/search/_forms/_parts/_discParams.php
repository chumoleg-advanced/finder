<?php
use \kartik\widgets\Select2;
use \common\models\wheelParam\WheelParam;
?>

<div class="col-md-2">
    <?= $form->field($model, 'diameter')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_DIAMETER),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('diameter')
        ]
    ]); ?>
</div>
<div class="col-md-2">
    <?= $form->field($model, 'points')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_POINTS),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('points')
        ]
    ]); ?>
</div>
<div class="col-md-2">
    <?= $form->field($model, 'width')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_WIDTH),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('width')
        ]
    ]); ?>
</div>
<div class="col-md-2">
    <?= $form->field($model, 'out')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_OUT),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('out')
        ]
    ]); ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'count')->textInput(
        ['placeholder' => $model->getAttributeLabel('count')]); ?>
</div>