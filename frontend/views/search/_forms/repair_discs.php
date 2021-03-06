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
    <div class="form-group placeListServices">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12 serviceRow">
            <div class="col-md-5 col-sm-6 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
            </div>
            <div class="col-md-7 col-sm-6 col-xs-12">
                <?= $form->field($modelData, '[0]comment')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <hr/>
            <?= $this->render('_parts/_discParams', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?php $model->discType = 1; ?>
                <?= $form->field($model, 'discType')->checkboxButtonGroup(CarData::$discTypeList); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>