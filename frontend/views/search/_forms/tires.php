<?php

use common\components\CarData;
use kartik\widgets\Select2;
use common\models\manufacturer\Manufacturer;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\WheelDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = SearchFormGenerator::getFormSingle($rubric->id);
$modelData = new \frontend\forms\request\QueryArrayForm();
?>
<div class="row carSelect">
    <div class="rw1170">
        <?= $this->render('_parts/_tireParams', ['form' => $form, 'model' => $model]); ?>
        <div class="clearfix"></div>

        <div class="collapse " id="additionCarData">
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
            <div class="clearfix"></div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $this->render('_parts/_price', ['form' => $form, 'model' => $model]); ?>
            </div>
        </div>

        <?= $this->render('_parts/_additionOptionsButton'); ?>

        <div class="clearfix"></div>
    </div>
</div>

<div class="clearfix"></div>
<div class="box">
    <div class="row dynamicFormRow">
        <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
            <h1>Моя заявка</h1>
            <a class="delBtn pull-right delete-item">
                Удалить
                <div class="svg">
                    <svg width="14" height="14" viewBox="0 0 14 14">
                      <path d="M14.000,1.400 L12.600,-0.000 L7.000,5.600 L1.400,-0.000 L-0.000,1.400 L5.600,7.000 L-0.000,12.600 L1.400,14.000 L7.000,8.400 L12.600,14.000 L14.000,12.600 L8.400,7.000 L14.000,1.400 Z" class="cls-1"/>
                    </svg>
                </div>
            </a>
        </div>
        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="pull-left">
                        <?= $form->field($model, 'tireType[]')->checkboxButtonGroup(CarData::$tireTypeList,
                            ['class' => 'buttonListTireType']); ?>
                    </div>

                    <div class="pull-left">
                        <?= $form->field($modelData, '[0]partsCondition')->checkboxButtonGroup(CarData::$wheelCondition); ?>
                    </div>
                    
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="tireTypeWinterParams">
                        <?= $form->field($model, 'tireTypeWinter[]')->checkboxButtonGroup(CarData::$tireTypeWinterList); ?>
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>
                </div>
            </div>
        </div>
    </div>  
</div>  

<div class="row wheelBg">
    <?= $this->render('_parts/_buttons'); ?>
</div>

<?php $form->end(); ?>