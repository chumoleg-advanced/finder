<?php
use \common\components\CarData;
use \kartik\widgets\Select2;

if (!isset($htmlClass)){
    $htmlClass = 'col-md-6';
}
?>

<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'vinNumber')->textInput(
        ['placeholder' => $model->getAttributeLabel('vinNumber')]); ?>
</div>
<div class="<?= $htmlClass; ?>">
    <?= $form->field($model, 'yearRelease')->textInput(
        ['placeholder' => $model->getAttributeLabel('yearRelease')]); ?>
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