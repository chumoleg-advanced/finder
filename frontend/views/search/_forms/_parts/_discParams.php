<?php
use kartik\widgets\Select2;
use common\models\wheelParam\WheelParam;

$htmlClass = 'col-md-2 col-sm-6 col-xs-12';
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
    <?= $form->field($model, 'points')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_POINTS),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('points')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'width')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_WIDTH),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('width')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'out')->widget(Select2::classname(), [
        'data'          => WheelParam::getListParams(WheelParam::DISC_OUT),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('out')
        ]
    ]); ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'count')->textInput(
        ['placeholder' => $model->getAttributeLabel('count')]); ?>
</div>