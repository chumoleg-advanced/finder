<?php

/** @var $model \frontend\searchForms\AutoServiceForm */

use \kartik\helpers\Html;
use \kartik\form\ActiveForm;
use \yii\captcha\Captcha;
use \common\models\car\CarFirm;
use \common\components\CarData;
use \kartik\widgets\Select2;

$carFirms = (new CarFirm())->getList();

$captchaOptions = [
    'captchaAction' => '/site/captcha',
    'options'       => ['class' => 'form-control'],
    'template'      => '<div class="col-md-4">{image}</div><div class="col-md-8">{input}</div>',
];
?>

<?php
$form = ActiveForm::begin([
    'id'          => 'auto-service-form',
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
                <?= $form->field($model, 'description[]')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'comment[]', [
                    'addon' => [
                        'append'  => [
                            'content'  => '<div class="fileUpload btn btn-primary"><span><i class="glyphicon glyphicon-camera"></i> Добавить фото</span><input type="file" class="upload" /></div>',
                            'asButton' => true
                        ]
                    ]
                ])->textInput(['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
            </div>
            <div class="col-md-1 deleteServiceDiv">
                <?= Html::button('-', ['class' => 'btn btn-default deleteService']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-12">
                <?= Html::button('Добавить еще одну работу', ['class' => 'btn btn-default addService']); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <hr>
            <div class="col-md-12">Для:</div>
            <div class="col-md-6">
                <?= $form->field($model, 'carFirm')->widget(Select2::classname(), [
                    'data'          => $carFirms,
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('carFirm'),
                        'class'       => 'carFirmSelect'
                    ]
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'carModel')->widget(Select2::classname(), [
                    'data'          => [],
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('carModel'),
                        'class'       => 'carModelSelect'
                    ]
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'carBody')->widget(Select2::classname(), [
                    'data'          => [],
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('carBody'),
                        'class'       => 'carBodySelect'
                    ]
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'carMotor')->widget(Select2::classname(), [
                    'data'          => [],
                    'pluginOptions' => ['allowClear' => true],
                    'options'       => [
                        'placeholder' => $model->getAttributeLabel('carMotor'),
                        'class'       => 'carMotor'
                    ]
                ]); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-12">
                <?= Html::button('Дополнительные опции ...',
                    ['class' => 'btn btn-default showAdditionOptions']); ?>
            </div>
        </div>
    </div>

    <div class="additionOptions">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                <div class="col-md-6">
                    <?= $form->field($model, 'vinNumber')->textInput(
                        ['placeholder' => $model->getAttributeLabel('vinNumber')]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'yearRelease')->textInput(
                        ['placeholder' => $model->getAttributeLabel('yearRelease')]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'drive')->widget(Select2::classname(), [
                        'data'          => CarData::$driveList,
                        'pluginOptions' => ['allowClear' => true],
                        'options'       => [
                            'placeholder' => $model->getAttributeLabel('drive')
                        ]
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'transmission')->widget(Select2::classname(), [
                        'data'          => CarData::$transmissionList,
                        'pluginOptions' => ['allowClear' => true],
                        'options'       => [
                            'placeholder' => $model->getAttributeLabel('transmission')
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="col-md-5">
                <div class="col-md-12">
                    <?= $form->field($model, 'withMe')->checkbox(['class' => 'showDistrictSelect']); ?>
                </div>
                <div class="col-md-12 districtSelect">
                    <?= $form->field($model, 'districtData')->widget(Select2::classname(), [
                        'data'          => [],
                        'pluginOptions' => ['allowClear' => true],
                        'options'       => [
                            'placeholder' => $model->getAttributeLabel('districtData')
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <hr>
            <?= $form->field($model, 'verifyCode')->widget(
                Captcha::className(), $captchaOptions); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <div class="col-md-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>