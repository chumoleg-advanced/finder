<?php

use common\models\company\CompanyRubric;
use yii\helpers\Html;
use common\models\category\Category;
use kartik\widgets\FileInput;
use common\models\request\RequestAttribute;

$service = $request->rubric->category_id == Category::SERVICE;

$descriptionLabel = 'Опишите работу';
$priceLabel = 'Стоимость работы';
if (!$service) {
    $descriptionLabel = 'Название запчасти или OEM-номер';
    $priceLabel = 'Цена';
}
?>

    <div class="row form-options-body">
        <div class="dynamicFormRow">
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
                <?= $form->field($modelData, '[0]price')->textInput(
                    ['class' => 'form-control', 'placeholder' => $priceLabel]); ?>

                <?= $form->field($modelData, '[0]companyId')->dropDownList(
                    CompanyRubric::getCompaniesByRubric($request->rubric_id),
                    ['prompt' => 'Компания']); ?>
            </div>

            <?php if (!$service) : ?>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <?= $form->field($modelData, '[0]availability')->dropDownList(
                        [1 => 'В наличии', 2 => 'Под заказ'], ['prompt' => 'Наличие']); ?>

                    <?= $form->field($modelData, '[0]partsCondition')->dropDownList(
                        RequestAttribute::getValueByRequest($request->id, 'partsCondition'),
                        ['prompt' => 'Состояние']); ?>

                    <?= $form->field($modelData, '[0]partsOriginal')->dropDownList(
                        RequestAttribute::getValueByRequest($request->id, 'partsOriginal'),
                        ['prompt' => 'Оригинальность']); ?>
                </div>
            <?php endif; ?>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr/>
            </div>
        </div>
    </div>

<?php if (!$service) : ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить еще одно предложение',
                ['class' => 'add-item btn btn-success btn-sm']); ?>
        </div>
    </div>
<?php endif; ?>