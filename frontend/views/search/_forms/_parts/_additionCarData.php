<?php
use common\components\CarData;
use kartik\widgets\Select2;

$htmlClass = 'col-md-3 col-sm-6 col-xs-12';
?>

<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'vinNumber')->textInput(
        ['placeholder' => $model->getAttributeLabel('vinNumber')]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'yearRelease')->widget(Select2::classname(), [
        'data'          => CarData::getYearRelease(),
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('yearRelease')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'drive')->widget(Select2::classname(), [
        'data'          => CarData::$driveList,
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('drive')
        ]
    ]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'transmission')->widget(Select2::classname(), [
        'data'          => CarData::$transmissionList,
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('transmission')
        ]
    ]); ?>
</div>