<?php

use common\components\CarData;
use frontend\forms\request\QueryArrayForm;
use frontend\components\SearchFormGenerator;

/** @var $model frontend\forms\request\RepairDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$modelData = new QueryArrayForm();

$form = SearchFormGenerator::getFormSingle($rubric->id);
?>
<div class="carSelect">
  <div class="rw1170">
    <?= $this->render('_parts/_discParams', ['form' => $form, 'model' => $model]); ?>
    <div class="clearfix"></div>
  </div>
</div>

<div class="clearfix"></div>
<div class="box">
    <div class="dynamicFormRow">
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
        <div class="form-group placeListServices">
            <div class="col-md-12 col-sm-12 col-xs-12 serviceRow">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]description')->textInput(
                        ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]comment')->textInput(
                        ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php $model->discType = 1; ?>
                    <?= $form->field($model, 'discType')->checkboxButtonGroup(CarData::$discTypeList); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row wheelBg">
    <?= $this->render('_parts/_buttons'); ?>
</div>

<?php $form->end(); ?>