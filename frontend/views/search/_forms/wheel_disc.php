<?php

use common\components\CarData;
use kartik\widgets\Select2;
use common\models\manufacturer\Manufacturer;
use app\components\SearchFormGenerator;

/** @var $model app\searchForms\WheelDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormSingle($rubric->id);
?>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-5 col-xs-12">
                <?= $form->field($model, 'manufacturer')->widget(Select2::classname(), [
                    'data'          => Manufacturer::getListByType(Manufacturer::TYPE_DISC),
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('manufacturer'),
                    ]
                ]); ?>
            </div>
            <div class="col-md-8 col-sm-7 col-xs-12">
                <?= $form->field($model, 'description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Укажите название или модель диска']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <?= $this->render('_parts/_discParams', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'type')->checkboxButtonGroup(CarData::$discTypeList); ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'condition')->checkboxButtonGroup(CarData::$wheelCondition); ?>
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