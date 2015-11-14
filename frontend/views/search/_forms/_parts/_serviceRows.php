<?php

/** @var $this \yii\web\View */

use \kartik\helpers\Html;
use \common\components\CarData;

if (!isset($buttonText)) {
    $buttonText = 'Добавить еще одну работу';
}

if (!isset($placeholder)) {
    $placeholder = 'Опишите работу';
}

if (isset($parts)) {
    $this->registerJs("$(document).ready(function(){
            $('.radioButtonListPartsCondition').find('input[value=" . $parts . "]')
            .trigger('click').trigger('change');});",
        \yii\web\View::POS_END, 'searchFormFirstSelect');
}
?>

<div class="form-group placeListServices">
    <div class="col-md-offset-2 col-md-10 serviceRow">
        <div class="col-md-5">
            <?= $form->field($model, 'description[]')->textInput(
                ['class' => 'form-control', 'placeholder' => $placeholder]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comment[]', [
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
        <div class="col-md-1 deleteServiceDiv">
            <?= Html::button('-', ['class' => 'btn btn-default deleteService']); ?>
        </div>

        <?php if (isset($parts)) : ?>
            <div class="col-md-5">
                <?= $form->field($model, 'condition[]')->radioButtonGroup(
                    CarData::$partsCondition, ['class' => 'radioButtonListPartsCondition']); ?>
            </div>
            <div class="col-md-6 partsOriginal">
                <?= $form->field($model, 'original[]')->radioButtonGroup(CarData::$partsOriginal); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <div class="col-md-12">
            <?= Html::button($buttonText, ['class' => 'btn btn-default addService']); ?>
        </div>
    </div>
</div>