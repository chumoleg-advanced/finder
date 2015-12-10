<?php

use \common\components\CarData;
use \frontend\searchForms\QueryArrayForm;
use frontend\components\ActiveFormGenerator;

/** @var $model \frontend\searchForms\RepairDiscForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$modelData = new QueryArrayForm();

$form = ActiveFormGenerator::getFormSingle($rubric->id, 'repair-disc-form');
?>
    <div class="form-group placeListServices">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12 serviceRow">
            <div class="col-md-5 col-sm-6 col-xs-12">
                <?= $form->field($modelData, 'description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
            </div>
            <div class="col-md-7 col-sm-6 col-xs-12">
                <?= $form->field($modelData, 'comment')->textInput(
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
                <?php $model->type = 1; ?>
                <?= $form->field($model, 'type')->checkboxButtonGroup(CarData::$discTypeList); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>

<?php $form->end(); ?>