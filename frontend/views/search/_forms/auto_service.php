<?php

/** @var $model \frontend\searchForms\AutoServiceForm */

use \yii\helpers\Html;
use \kartik\form\ActiveForm;
use \yii\captcha\Captcha;
use \common\models\car\CarFirm;
use \common\components\CarData;

$carFirms = (new CarFirm())->getList();

$captchaOptions = [
    'captchaAction' => '/site/captcha',
    'options'       => ['class' => 'form-control'],
    'template'      => '<div class="col-md-12"><div class="col-md-3">{image}</div>
        <div class="col-md-9">{input}</div></div>',
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-9">
            <?php
            $form = ActiveForm::begin([
                'id'          => 'auto-service-form',
                'fieldConfig' => [
                    'template' => "{input}\n{hint}\n{error}",
                ],
            ]);

            ?>
            <div class="col-md-12">
                <div class="col-md-2">Мне нужно:</div>
                <div class="col-md-10 formDiv borderDashed">
                    <div class="col-md-6">
                        <?= Html::textInput('description', null,
                            ['class' => 'form-control', 'placeholder' => 'Опишите работу']); ?>
                    </div>
                    <div class="col-md-6">
                        <?= Html::textInput('comment', null,
                            ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-10 formDiv">
                    <?= Html::button('Добавить еще одну работу', ['class' => 'btn btn-default']); ?>
                    <?= $form->field($model, 'subjectData')->hiddenInput(); ?>
                </div>

            </div>

            <div class="col-md-12">
                <div class="col-md-2">Для:</div>
                <div class="col-md-10 formDiv">
                    <?php
                    echo $form->field($model, 'carFirm')->dropDownList($carFirms, [
                        'prompt' => $model->getAttributeLabel('carFirm'),
                        'class'  => 'carFirmSelect'
                    ]);
                    ?>

                    <?php echo $form->field($model, 'carModel')->dropDownList([], [
                        'prompt' => $model->getAttributeLabel('carModel'),
                        'class'  => 'carModelSelect'
                    ]); ?>

                    <?= $form->field($model, 'carBody')->dropDownList([], [
                        'prompt' => $model->getAttributeLabel('carBody'),
                        'class'  => 'carBodySelect'
                    ]); ?>

                    <?= $form->field($model, 'carMotor')->dropDownList([], [
                        'prompt' => $model->getAttributeLabel('carMotor'),
                        'class'  => 'carMotorSelect'
                    ]); ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-10 formDiv borderDashed">
                    <div class="col-md-6">
                        <?= $form->field($model, 'vinNumber')->textInput(
                            ['placeholder' => $model->getAttributeLabel('vinNumber')]); ?>

                        <?= $form->field($model, 'yearRelease')->textInput(
                            ['placeholder' => $model->getAttributeLabel('yearRelease')]); ?>

                        <?= $form->field($model, 'drive')->dropDownList(CarData::$driveList,
                            ['prompt' => $model->getAttributeLabel('drive')]); ?>

                        <?= $form->field($model, 'transmission')->dropDownList(CarData::$transmissionList,
                            ['prompt' => $model->getAttributeLabel('transmission')]); ?>
                    </div>
                    <div class="col-md-6 formDiv">
                        <?= $form->field($model, 'withMe')->checkbox(); ?><br/>
                        <?= $form->field($model, 'districtData')->dropDownList([],
                            ['prompt' => $model->getAttributeLabel('districtData')]); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-10 formDiv">
                    <?= $form->field($model, 'verifyCode')->widget(
                        Captcha::className(), $captchaOptions); ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-10 formDiv right">
                    <?= Html::submitButton(Yii::t('app', 'Отправить заявку'),
                        ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-3">&nbsp;</div>
    </div>
</div>