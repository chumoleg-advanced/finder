<?php

use common\components\CarData;
use kartik\widgets\Select2;
use common\models\manufacturer\Manufacturer;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\searchForms\WheelDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormSingle($rubric->id);
$modelData = new \frontend\searchForms\QueryArrayForm();
?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-5 col-xs-12">
                <?= $form->field($model, 'manufacturer')->widget(Select2::classname(), [
                    'data'          => Manufacturer::getListByType(Manufacturer::TYPE_TIRE),
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('manufacturer'),
                    ]
                ]); ?>
            </div>
            <div class="col-md-8 col-sm-7 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Укажите название или модель шин']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <?= $this->render('_parts/_tireParams', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'type[]')->checkboxButtonGroup(CarData::$tireTypeList,
                    ['class' => 'buttonListTireType']); ?>
            </div>

            <div class="tireTypeWinterParams col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'typeWinter[]')->checkboxButtonGroup(CarData::$tireTypeWinterList); ?>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelData, '[0]condition')->checkboxButtonGroup(CarData::$wheelCondition); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>

<?= $this->render('_parts/_additionOptionsButton'); ?>

    <div class="additionOptions">
        <?= $this->render('_parts/_price', ['form' => $form, 'model' => $model]); ?>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>