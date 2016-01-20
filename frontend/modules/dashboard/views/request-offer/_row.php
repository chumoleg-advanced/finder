<?php

use common\models\company\CompanyRubric;
use yii\helpers\Html;
use kartik\widgets\FileInput;
use common\models\request\RequestAttribute;

$descriptionLabel = 'Опишите работу';
$priceLabel = 'Стоимость работы';
if (!$service) {
    $descriptionLabel = 'Название запчасти или OEM-номер';
    $priceLabel = 'Цена';
}

$isNewRecord = true;
if ($modelData->id) {
    $isNewRecord = false;
}
?>

<div class="row dynamicFormRow">
    <?php
    if (!empty($modelData->id) && isset($i)) {
        echo Html::activeHiddenInput($modelData, "[{$i}]id");
    }
    ?>

    <div class="col-md-5 col-sm-5 col-xs-12">
        <?= $form->field($modelData, '[0]description')->textInput([
            'placeholder' => $descriptionLabel,
            'class'       => 'form-control descriptionQuery'
        ]); ?>
    </div>

    <div class="col-md-5 col-sm-5 col-xs-8">
        <?= $form->field($modelData, '[0]comment')->textInput(
            ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
    </div>

    <div class="col-md-1 col-sm-1 col-xs-2">
        <a class="btn btn-primary showFileUpload">
            <i class="glyphicon glyphicon-camera"></i>
        </a>
    </div>

    <?php if (!$service) : ?>
        <div class="col-md-1 col-sm-1 col-xs-2 deleteServiceDiv">
            <a class="btn btn-default delete-item">
                <i class="glyphicon glyphicon-minus"></i>
            </a>
        </div>
    <?php endif; ?>

    <div class="form-group"></div>

    <?php
    $fileInputParams = [
        'language'      => 'ru',
        'options'       => [
            'multiple' => true,
            'accept'   => 'image/*',
            'class'    => 'option-value-img'
        ],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png'],
            'maxFileSize'           => 5000000,
            'maxFileCount'          => 5,
            'previewFileType'       => 'image',
            'showRemove'            => false,
            'showCaption'           => false,
            'showUpload'            => false,
            'browseClass'           => 'btn btn-primary',
            'browseIcon'            => '<i class="glyphicon glyphicon-camera"></i>',
            'removeIcon'            => '<i class="fa fa-trash"></i>',
            'previewSettings'       => [
                'image' => ['width' => '100px', 'height' => '100px'],
            ],
        ]
    ];

    $preview = [];
    if (!empty($modelData->imageData)) {
        foreach ($modelData->imageData as $image) {
            $preview[] = Html::img('/' . $image->thumb_name, ['class' => 'file-preview-image']);
        }
    }

    $imageDisplay = 'none;';
    if (!empty($preview)) {
        $fileInputParams['pluginOptions']['initialPreview'] = $preview;
        $imageDisplay = 'block;';
    }
    ?>

    <div class="uploadFilesBlock col-md-12 col-sm-12 col-xs-12" style="display: <?= $imageDisplay; ?>">
        <?= $form->field($modelData, '[0]imageData[]')->widget(FileInput::className(), $fileInputParams); ?>
    </div>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($modelData, '[0]price')->textInput(
                    ['class' => 'form-control', 'placeholder' => $priceLabel]); ?>
            </div>

            <div class="col-md-12">
                <?php
                $companiesList = CompanyRubric::getCompaniesByRubric($request->rubric_id);
                if ($isNewRecord) {
                    $modelData->companyId = current(array_keys($companiesList));
                }

                echo $form->field($modelData, '[0]companyId')->dropDownList($companiesList);
                ?>
            </div>
        </div>
    </div>

    <?php if (!$service) : ?>
        <div class="col-md-5 col-sm-5 col-xs-6">
            <?php
            $availability = [1 => 'В наличии', 2 => 'Под заказ'];
            if ($isNewRecord) {
                $modelData->availability = 1;
            }

            echo $form->field($modelData, '[0]availability')->radioButtonGroup($availability, [
                'class'       => 'btn-group buttonListAvailability',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
            ]);
            ?>

            <div class="row deliveryDays">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]deliveryDayFrom')
                        ->textInput(['placeholder' => 'Срок от']); ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]deliveryDayTo')
                        ->textInput(['placeholder' => 'до']); ?>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-sm-5 col-xs-6">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $partsCondition = RequestAttribute::getValueByRequest($request->id, 'partsCondition');
                    if ($isNewRecord) {
                        $modelData->partsCondition = current(array_keys($partsCondition));
                    }

                    echo $form->field($modelData, '[0]partsCondition')->radioButtonGroup($partsCondition, [
                        'class'       => 'btn-group',
                        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                    ]);
                    ?>
                </div>
                <div class="col-md-12">
                    <?php
                    $partsOriginal = RequestAttribute::getValueByRequest($request->id, 'partsOriginal');
                    if ($isNewRecord) {
                        $modelData->partsOriginal = current(array_keys($partsOriginal));
                    }

                    echo $form->field($modelData, '[0]partsOriginal')->radioButtonGroup($partsOriginal, [
                        'class'       => 'btn-group',
                        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <hr/>
    </div>
</div>