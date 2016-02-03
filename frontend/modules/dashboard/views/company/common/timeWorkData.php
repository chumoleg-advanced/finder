<?php
use frontend\modules\dashboard\forms\company\MainData;
use kartik\helpers\Html;

?>

    <div>&nbsp;</div>
    <b>Время работы:</b>
<?php
$inputOptions = [
    'template' => "{error}\n{input}\n{hint}",
    'options'  => ['class' => 'form-group radioButtonFormGroup']
];

echo isset($asString) ? '<div>&nbsp;</div>' . $asString : null;
?>

<?php for ($i = 0; $i <= 1; $i++) : ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'timeWork[' . $i . '][days][]', $inputOptions)
                ->checkboxButtonGroup(MainData::getWeekDays(), [
                    'class'       => 'btn-group weekDaysGroup field-timeWork-' . $i,
                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                ]); ?>
        </div>

        <div class="col-md-4">
            с <?= Html::activeDropDownList($model, 'timeWork[' . $i . '][timeFrom]',
                MainData::getRange(), ['class' => 'dropDownTimes timeFrom']); ?>
            до <?= Html::activeDropDownList($model, 'timeWork[' . $i . '][timeTo]',
                MainData::getRange(1, 24), ['class' => 'dropDownTimes timeTo']); ?>
        </div>
    </div>
<?php endfor; ?>