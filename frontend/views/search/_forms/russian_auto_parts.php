<?php

use \kartik\form\ActiveForm;
use \common\components\Status;
use common\models\car\CarFirm;

/** @var $model \frontend\searchForms\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = ActiveForm::begin([
    'id'          => 'russian-auto-part-form',
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

<?= $this->render('_parts/_serviceRows', [
    'form'        => $form,
    'model'       => $model,
    'buttonText'  => 'Добавить еще одну запчасть',
    'placeholder' => 'Название запчасти',
]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <hr/>
            <?= $this->render('_parts/_carSelect', [
                'form'                 => $form,
                'model'                => $model,
                'carFirms'             => (new CarFirm())->getListByImport(Status::STATUS_DISABLED),
                'withoutBodyAndEngine' => true
            ]); ?>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>

    <div class="additionOptions">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                <?= $this->render('_parts/_additionCarData',
                    ['form' => $form, 'model' => $model, 'htmlClass' => 'col-md-12']); ?>
            </div>
            <div class="col-md-5">
                <?= $this->render('_parts/_needleDelivery', ['form' => $form, 'model' => $model]); ?>
                <?= $this->render('_parts/_districtWithMe', ['form' => $form, 'model' => $model]); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>