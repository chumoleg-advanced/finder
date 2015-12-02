<?php

use \frontend\searchForms\QueryArrayForm;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use \common\components\CarData;
use \kartik\helpers\Html;
use \frontend\assets\FormPartSearchAsset;

if (!isset($buttonText)) {
    $buttonText = 'Добавить еще одну работу';
}

if (!isset($placeholder)) {
    $placeholder = 'Опишите работу';
}

FormPartSearchAsset::register($this);

if (isset($parts)) {
    $this->registerJs("$(document).ready(function(){
            $('.buttonListPartsCondition').find('input[value=" . $parts . "]')
            .trigger('click').trigger('change');});",
        \yii\web\View::POS_END, 'searchFormFirstSelect');

    $this->registerJs("$(document).ready(function(){activateAutoComplete();});",
        \yii\web\View::POS_END, 'searchFormInitAutoComplete');
}

$modelData = new QueryArrayForm();
?>


<?php DynamicFormWidget::begin([
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
]); ?>

    <div class="form-group form-options-body partsSearch">
        <div class="dynamicFormRow col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput([
                    'placeholder' => $placeholder,
                    'class'       => 'form-control descriptionQuery'
                ]); ?>
            </div>

            <div class="col-md-5 col-sm-5 col-xs-7">
                <?= $form->field($modelData, '[0]comment')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-3">
                <a class="btn btn-primary btn-block showFileUpload">
                    <i class="glyphicon glyphicon-camera"></i>
                </a>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-2 deleteServiceDiv">
                <button type="button" class="delete-item btn btn-default">
                    <i class="glyphicon glyphicon-minus"></i>
                </button>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12 partsSide">
                    <div class="col-md-5 col-sm-6 col-xs-12 text-center">
                        <div class="btn-group-xs" style="display: block;">
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
                </div>
            </div>

            <?php if (isset($parts)) : ?>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <input name="QueryArrayForm[0][condition]" value="" type="hidden">

                    <div id="queryarrayform-0-condition" class="buttonListPartsCondition btn-group"
                         data-toggle="buttons">
                        <?php foreach (CarData::$partsCondition as $id => $label) : ?>
                            <label class="btn btn-default">
                                <input name="QueryArrayForm[0][condition][]" value="<?= $id; ?>"
                                       data-value="<?= $id; ?>" type="checkbox"><?= $label; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 partsOriginal">
                    <input name="QueryArrayForm[0][original]" value="" type="hidden">

                    <div id="queryarrayform-0-original" class="btn-group"
                         data-toggle="buttons">
                        <?php foreach (CarData::$partsOriginal as $id => $label) : ?>
                            <label class="btn btn-default">
                                <input name="QueryArrayForm[0][original][]" value="<?= $id; ?>"
                                       data-value="<?= $id; ?>" type="checkbox"><?= $label; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
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