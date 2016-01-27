<?php

use frontend\searchForms\QueryArrayForm;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use common\components\CarData;
use kartik\helpers\Html;
use frontend\assets\FormPartSearchAsset;

if (!isset($buttonText)) {
    $buttonText = 'Добавить еще одну работу';
}

if (!isset($placeholder)) {
    $placeholder = 'Опишите работу';
}

FormPartSearchAsset::register($this);

$modelData = new QueryArrayForm();

if (isset($parts)) {
    $this->registerJs("$(document).ready(function(){
            $('.buttonListPartsCondition').find('input[value=1]')
            .trigger('click').trigger('change');});",
        \yii\web\View::POS_END, 'searchFormFirstSelect');

    $this->registerJs("$(document).ready(function(){activateAutoComplete();});",
        \yii\web\View::POS_END, 'searchFormInitAutoComplete');

    $modelData->setScenario('parts');
}

$dynamicParams = [
    'widgetContainer' => 'partsSearchDynamicForm',
    'widgetBody'      => '.form-options-body',
    'widgetItem'      => '.dynamicFormRow',
    'min'             => 1,
    'insertButton'    => '.add-item',
    'deleteButton'    => '.delete-item',
    'model'           => $modelData,
    'formId'          => \frontend\components\SearchFormGenerator::FORM_ID,
    'formFields'      => [
        'description',
        'comment'
    ],
];
?>

<?php DynamicFormWidget::begin($dynamicParams); ?>

    <div class="form-group form-options-body partsSearch">
        <div class="dynamicFormRow col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput([
                    'placeholder' => $placeholder,
                    'class'       => 'form-control descriptionQuery'
                ]); ?>

                <div class="btn-group-xs partsSide text-center" style="display: block;">
                    <a match="лев" class="ajaxLink sideLeft" href="#">левый</a> &ndash;
                    <a match="прав" class="ajaxLink sideRight" href="#">правый</a>,
                    &nbsp;&nbsp;&nbsp;
                    <a match="перед" class="ajaxLink" href="#">передний</a> &ndash;
                    <a match="зад" class="ajaxLink" href="#">задний</a>,
                    &nbsp;&nbsp;&nbsp;
                    <a match="верх" class="ajaxLink" href="#">верхний</a> &ndash;
                    <a match="ниж" class="ajaxLink" href="#">нижний</a>
                </div>
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

            <div class="col-md-1 col-sm-1 col-xs-2 deleteServiceDiv">
                <a class="btn btn-default delete-item">
                    <i class="glyphicon glyphicon-minus"></i>
                </a>
            </div>

            <div class="form-group"></div>

            <?php if (isset($parts)) : ?>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]partsCondition')->checkboxButtonGroup(CarData::$partsCondition, [
                        'class'       => 'btn-group buttonListPartsCondition',
                        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                    ]); ?>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12 partsOriginal">
                    <?= $form->field($modelData, '[0]partsOriginal')->checkboxButtonGroup(CarData::$partsOriginal, [
                        'class'       => 'btn-group',
                        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                    ]); ?>
                </div>
            <?php endif; ?>

            <div class="uploadFilesBlock col-md-12 col-sm-12 col-xs-12">
                <?= $form->field($modelData, '[0]image[]')->widget(FileInput::className(), [
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
                        ]
                    ]
                ]);
                ?>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <hr/>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= Html::button('<i class="glyphicon glyphicon-plus"></i> ' . $buttonText,
                    ['class' => 'add-item btn btn-success btn-sm']); ?>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>