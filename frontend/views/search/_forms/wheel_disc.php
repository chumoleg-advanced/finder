<?php

use \kartik\form\ActiveForm;
use \common\components\CarData;
use \kartik\widgets\Select2;
use \common\models\manufacturer\Manufacturer;

/** @var $model \frontend\searchForms\WheelDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = ActiveForm::begin([
    'id'          => 'wheel-disc-form',
    'type'        => ActiveForm::TYPE_HORIZONTAL,
    'formConfig'  => [
        'showLabels' => false,
        'deviceSize' => ActiveForm::SIZE_MEDIUM
    ],
    'fieldConfig' => [
        'template' => "{input}\n{hint}\n{error}",
    ],
]);
?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-4">
                <?= $form->field($model, 'manufacturer')->widget(Select2::classname(), [
                    'data'          => (new Manufacturer())->getListByType(Manufacturer::TYPE_DISC),
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('manufacturer'),
                    ]
                ]); ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Укажите название или модель диска']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <?= $this->render('_parts/_discParams', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-6">
                <?= $form->field($model, 'type')->radioButtonGroup(CarData::$discTypeList); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'condition')->radioButtonGroup(CarData::$wheelCondition); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>

    <div class="additionOptions">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                <?= $this->render('_parts/_price', ['form' => $form, 'model' => $model]); ?>
                <?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>
                <?= $this->render('_parts/_districtWithMe', ['form' => $form, 'model' => $model]); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>