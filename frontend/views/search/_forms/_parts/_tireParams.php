<?php
use kartik\widgets\Select2;
use common\models\wheelParam\WheelParam;

$htmlClass = 'col-md-3 col-sm-6 col-xs-12';
?>

<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'diameter')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_DIAMETER),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('diameter')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'width')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::TIRE_WIDTH),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('width')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'height')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::TIRE_HEIGHT),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('height')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'count')->textInput(
        ['placeholder' => $model->getAttributeLabel('count')]); ?>
</div>