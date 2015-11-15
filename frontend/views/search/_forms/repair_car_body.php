<?php

use \kartik\form\ActiveForm;
use common\models\car\CarFirm;

/** @var $model \frontend\searchForms\AutoServiceForm */
/** @var $this \yii\web\View */

$form = ActiveForm::begin([
    'id'          => 'repair-car-body-form',
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

<?= $this->render('_parts/_serviceRows', ['form' => $form, 'model' => $model]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <hr/>
            <?= $this->render('_parts/_carSelect',
                ['form' => $form, 'model' => $model, 'carFirms' => (new CarFirm())->getList()]); ?>

            <div class="col-md-6">
                <?= $form->field($model, 'color')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Цвет']); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>

    <div class="additionOptions">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                <?= $this->render('_parts/_additionCarData', ['form' => $form, 'model' => $model]); ?>
            </div>
            <div class="col-md-5">
                <?= $this->render('_parts/_districtWithMe', ['form' => $form, 'model' => $model]); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>