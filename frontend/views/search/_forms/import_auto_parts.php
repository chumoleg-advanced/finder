<?php

use \kartik\form\ActiveForm;
use \common\components\Status;
use common\models\car\CarFirm;

/** @var $model \frontend\searchForms\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

// @TODO костыль с выбором первоначального состояния запчасти
$selectedCondition = 1;
if ($rubric->id == 10) {
    $selectedCondition = 3;
} elseif ($rubric->id == 11) {
    $selectedCondition = 2;
}

$form = ActiveForm::begin([
    'id'          => 'import-auto-part-form',
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
    'placeholder' => 'Запчасть или OEM номер',
    'parts'       => $selectedCondition
]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <hr/>
            <?= $this->render('_parts/_carSelect', [
                'form'     => $form,
                'model'    => $model,
                'carFirms' => (new CarFirm())->getListByImport(Status::STATUS_ACTIVE)
            ]); ?>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>

<?= $this->render('_parts/_additionBlockWithDelivery', ['form' => $form, 'model' => $model]); ?>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>