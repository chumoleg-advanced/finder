<?php

use \kartik\form\ActiveForm;
use \common\components\CarData;

/** @var $model \frontend\searchForms\RepairDiscForm */
/** @var $this \yii\web\View */

$form = ActiveForm::begin([
    'id'          => 'repair-disc-form',
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
    <div class="form-group placeListServices">
        <div class="col-md-offset-2 col-md-10 serviceRow">
            <div class="col-md-5">
                <?= $form->field($model, 'description')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
            </div>
            <div class="col-md-7">
                <?= $form->field($model, 'comment', [
                    'addon' => [
                        'append' => [
                            'content'  => '<div class="fileUpload btn btn-primary"><span>
                                <i class="glyphicon glyphicon-camera"></i> Добавить фото</span>
                                <input type="file" class="upload" /></div>',
                            'asButton' => true
                        ]
                    ]
                ])->textInput(['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <hr/>
            <?= $this->render('_parts/_discParams', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-6">
                <?php $model->type = 1; ?>
                <?= $form->field($model, 'type')->radioButtonGroup(CarData::$discTypeList); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_additionOptionsButton'); ?>

    <div class="additionOptions">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                <?= $this->render('_parts/_districtWithMe', ['form' => $form, 'model' => $model]); ?>
            </div>
        </div>
    </div>

<?= $this->render('_parts/_captcha', ['form' => $form, 'model' => $model]); ?>
<?= $this->render('_parts/_buttons'); ?>
<?php ActiveForm::end(); ?>