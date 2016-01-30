<?php

use kartik\widgets\FileInput;

$descriptionLabel = 'Опишите работу';
$priceLabel = 'Стоимость работы';
if (!$service) {
    $descriptionLabel = 'Название запчасти или OEM-номер';
    $priceLabel = 'Цена';
}
?>

<div class="row dynamicFormRow">
    <?php
    if (!isset($i)) {
        $i = 0;
    }
    ?>

    <div class="col-md-5 col-sm-5 col-xs-12">
        <?= $form->field($modelData, '[' . $i . ']description')->textInput([
            'placeholder' => $descriptionLabel,
            'class'       => 'form-control descriptionQuery',
        ]); ?>
    </div>

    <div class="col-md-5 col-sm-5 col-xs-8">
        <?= $form->field($modelData, '[' . $i . ']comment')->textInput([
            'class'       => 'form-control',
            'placeholder' => 'Комментарий',
        ]); ?>
    </div>

    <div class="col-md-1 col-sm-1 col-xs-2">
        <a class="btn btn-primary showFileUpload">
            <i class="glyphicon glyphicon-camera"></i>
        </a>
    </div>

    <?php if (!$service) : ?>
        <div class="col-md-1 col-sm-1 col-xs-2 deleteServiceDiv">
            <a class="btn btn-default deleteItem">
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
        ],
    ];
    ?>

    <?php if (!empty($modelData->imageData)) : ?>
        <div class="col-md-12 col-sm-12 col-xs-12 imagesPreview">
            <?php foreach ($modelData->imageData as $image) : ?>
                <a class="fancybox imageBlock" rel="gallery_<?= $i; ?>" href="<?= '/' . $image->name; ?>">
                    <img src="<?= '/' . $image->thumb_name; ?>" alt=""/>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="uploadFilesBlock col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($modelData, '[' . $i . ']imageData[]')->widget(FileInput::className(), $fileInputParams); ?>
    </div>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($modelData, '[' . $i . ']price')->textInput([
                    'class'       => 'form-control',
                    'placeholder' => $priceLabel,
                ]); ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($modelData, '[' . $i . ']companyId')->dropDownList($companiesList); ?>
            </div>
        </div>
    </div>

    <?php if (!$service) : ?>
        <?php if (!empty($availability)) : ?>
            <div class="col-md-5 col-sm-5 col-xs-6">
                <?php
                echo $form->field($modelData, '[' . $i . ']availability')->radioButtonGroup($availability, [
                    'class'       => 'btn-group buttonListAvailability',
                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                ]);

                $visibleDeliveryDays = 'none';
                if ($modelData->availability == 2) {
                    $visibleDeliveryDays = 'block';
                }
                ?>
                <div class="row deliveryDays" style="display: <?= $visibleDeliveryDays; ?>;">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($modelData, '[' . $i . ']deliveryDayFrom')
                            ->textInput(['placeholder' => 'Срок от']); ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($modelData, '[' . $i . ']deliveryDayTo')
                            ->textInput(['placeholder' => 'до']); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-md-5 col-sm-5 col-xs-6">
            <div class="row">
                <?php if (!empty($partsCondition)) : ?>
                    <div class="col-md-12">
                        <?= $form->field($modelData, '[' . $i . ']partsCondition')->radioButtonGroup($partsCondition, [
                            'class'       => 'btn-group buttonListPartsCondition',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                        ]); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($partsOriginal)) : ?>
                    <?php
                    $visiblePartsOriginal = 'none';
                    if ($modelData->partsCondition == 1) {
                        $visiblePartsOriginal = 'block';
                    }
                    ?>

                    <div class="col-md-12 partsOriginalBlock" style="display: <?= $visiblePartsOriginal; ?>;">
                        <?= $form->field($modelData, '[' . $i . ']partsOriginal')->radioButtonGroup($partsOriginal, [
                            'class'       => 'btn-group',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-12 col-sm-12 col-xs-12 boldBorderBottom">
    </div>
</div>