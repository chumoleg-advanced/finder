<?php

use \kartik\form\ActiveForm;
use \common\components\Status;
use common\models\car\CarFirm;

/** @var $model \frontend\searchForms\AutoPartForm */
/** @var $rubric common\models\rubric\Rubric */
/** @var $this \yii\web\View */

$form = ActiveForm::begin([
    'type'        => ActiveForm::TYPE_HORIZONTAL,
    'formConfig'  => [
        'showLabels' => false,
        'deviceSize' => ActiveForm::SIZE_MEDIUM
    ],
    'fieldConfig' => [
        'template' => "{input}\n{hint}\n{error}",
    ],
    'options'     => [
        'enctype' => 'multipart/form-data',
        'id' => 'auto-service-form'
    ]
]);
?>

<?= $this->render('_parts/_partOrServiceRow', [
    'form'        => $form,
    'model'       => $model,
    'buttonText'  => 'Добавить еще одну запчасть',
    'placeholder' => 'Название запчасти',
]); ?>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
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

<?= $this->render('_parts/_additionBlockWithDelivery', ['form' => $form, 'model' => $model]); ?>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>