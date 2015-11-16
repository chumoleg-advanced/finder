<div class="col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'withMe')->checkbox(['class' => 'showDistrictSelect']); ?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 districtSelect">
    <?= $form->field($model, 'districtData')->widget(\kartik\widgets\Select2::classname(), [
        'data'          => [],
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('districtData')
        ]
    ]); ?>
</div>