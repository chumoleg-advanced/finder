<div class="col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'withMe')->checkbox(['class' => 'showDistrictSelect']); ?>
</div>

<?php ?>
<div class="col-md-6 col-sm-6 col-xs-12 districtSelect">
    <?= $form->field($model, 'districtData')->widget(\kartik\widgets\Select2::classname(), [
        'data'          => [],
        'pluginOptions' => ['allowClear' => true],
        'options'       => [
            'placeholder' => $model->getAttributeLabel('districtData')
        ]
    ]); ?>
</div>