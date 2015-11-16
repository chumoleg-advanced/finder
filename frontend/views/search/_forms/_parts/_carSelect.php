<?php
use \kartik\widgets\Select2;

$htmlClass = 'col-md-3 col-sm-6 col-xs-12';
?>
    <div class="<?= $htmlClass; ?>">
        <?= $form->field($model, 'carFirm')->widget(Select2::classname(), [
            'data'          => $carFirms,
            'pluginOptions' => ['allowClear' => true],
            'options'       => [
                'placeholder' => $model->getAttributeLabel('carFirm'),
                'class'       => 'carFirmSelect'
            ]
        ]); ?>
    </div>
    <div class="<?= $htmlClass; ?>">
        <?= $form->field($model, 'carModel')->widget(Select2::classname(), [
            'data'          => [],
            'pluginOptions' => ['allowClear' => true],
            'options'       => [
                'placeholder' => $model->getAttributeLabel('carModel'),
                'class'       => 'carModelSelect'
            ]
        ]); ?>
    </div>

<?php if (!isset($withoutBodyAndEngine)) : ?>
    <div class="<?= $htmlClass; ?>">
        <?= $form->field($model, 'carBody')->widget(Select2::classname(), [
            'data'          => [],
            'pluginOptions' => ['allowClear' => true],
            'options'       => [
                'placeholder' => $model->getAttributeLabel('carBody'),
                'class'       => 'carBodySelect'
            ]
        ]); ?>
    </div>
    <div class="<?= $htmlClass; ?>">
        <?= $form->field($model, 'carEngine')->widget(Select2::classname(), [
            'data'          => [],
            'pluginOptions' => ['allowClear' => true],
            'options'       => [
                'placeholder' => $model->getAttributeLabel('carEngine'),
                'class'       => 'carEngine'
            ]
        ]); ?>
    </div>
<?php endif; ?>