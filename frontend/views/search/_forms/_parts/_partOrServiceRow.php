<?php

use app\searchForms\QueryArrayForm;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use common\components\CarData;
use kartik\helpers\Html;
use app\assets\FormPartSearchAsset;

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
            $('.buttonListPartsCondition').find('input[value=" . $parts . "]')
            .trigger('click').trigger('change');});",
        \yii\web\View::POS_END, 'searchFormFirstSelect');

    $this->registerJs("$(document).ready(function(){activateAutoComplete();});",
        \yii\web\View::POS_END, 'searchFormInitAutoComplete');

    $modelData->setScenario('parts');
}

$dynamicParams = [
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody'      => '.form-options-body',
    'widgetItem'      => '.dynamicFormRow',
    'min'             => 1,
    'insertButton'    => '.add-item',
    'deleteButton'    => '.delete-item',
    'model'           => $modelData,
    'formId'          => 'auto-service-form',
    'formFields'      => [
        'description',
        'comment',
        'image'
    ],
];

if (isset($parts)) {
    $dynamicParams['formFields'][] = 'condition';
    $dynamicParams['formFields'][] = 'original';
}
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
                    <?= $form->field($modelData, '[0]condition')->checkboxButtonGroup(CarData::$partsCondition, [
                        'class'       => 'btn-group buttonListPartsCondition',
                        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                    ]); ?>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12 partsOriginal">
                    <?= $form->field($modelData, '[0]original')->checkboxButtonGroup(CarData::$partsOriginal, [
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
                        'afterInsert'     => '_hideCheckBoxButtonMiddle()',
                        'previewFileType' => 'image',
                        'showRemove'      => false,
                        'showCaption'     => false,
                        'showUpload'      => false,
                        'browseClass'     => 'btn btn-primary',
                        'browseIcon'      => '<i class="glyphicon glyphicon-camera"></i>',
                        'removeIcon'      => '<i class="fa fa-trash"></i>',
                        'uploadUrl'       => \yii\helpers\Url::to(['/site/file-upload']),
                        'previewSettings' => [
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
                <?= Html::button($buttonText, ['class' => 'add-item btn btn-success btn-sm']); ?>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>