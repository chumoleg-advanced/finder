<?php

/** @var $this \yii\web\View */

use \kartik\helpers\Html;
use \kartik\file\FileInput;
use \common\components\CarData;

if (!isset($buttonText)) {
    $buttonText = 'Добавить еще одну работу';
}

if (!isset($placeholder)) {
    $placeholder = 'Опишите работу';
}

if (isset($parts)) {
    $this->registerJs("$(document).ready(function(){
            $('.buttonListPartsCondition').find('input[value=" . $parts . "]')
            .trigger('click').trigger('change');});",
        \yii\web\View::POS_END, 'searchFormFirstSelect');
}
?>

<div class="form-group placeListServices">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12 serviceRow">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?= $form->field($model, 'description[]')->textInput(
                ['class' => 'form-control', 'placeholder' => $placeholder]); ?>
        </div>
        <div class="col-md-5 col-sm-5 col-xs-8">
            <?= $form->field($model, 'comment[]')->textInput(
                ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-2">
            <?= FileInput::widget([
                'model'         => $model,
                'name'          => 'image[]',
                'pluginOptions' => [
                    'showCaption' => false,
                    'showRemove'  => false,
                    'showUpload'  => false,
                    'showPreview' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon'  => '<i class="glyphicon glyphicon-camera"></i>',
                    'browseLabel' => '',
                ],
                'options'       => ['multiple' => true, 'accept' => 'image/*']
            ]);
            ?>
        </div>
        <div class="col-md-1 col-sm-1 col-xs-2 deleteServiceDiv">
            <?= Html::button('-', ['class' => 'btn btn-default deleteService']); ?>
        </div>

        <?php if (isset($parts)) : ?>
            <div class="col-md-5 col-sm-6 col-xs-12">
                <?= $form->field($model, 'condition[]')->checkboxButtonGroup(
                    CarData::$partsCondition, ['class' => 'buttonListPartsCondition']); ?>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 partsOriginal">
                <?= $form->field($model, 'original[]')->checkboxButtonGroup(CarData::$partsOriginal); ?>
            </div>
        <?php endif; ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <hr/>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?= Html::button($buttonText, ['class' => 'btn btn-default addService']); ?>
        </div>
    </div>
</div>