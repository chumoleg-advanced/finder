<?php

use yii\jui\JuiAsset;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use \common\components\CarData;
use \kartik\helpers\Html;

if (!isset($buttonText)) {
    $buttonText = 'Добавить еще одну работу';
}

if (!isset($placeholder)) {
    $placeholder = 'Опишите работу';
}

$modelData = new \frontend\searchForms\QueryArrayForm();
?>


<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody'      => '.form-options-body',
    'widgetItem'      => '.form-options-item',
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

    <div class="form-group form-options-body">
        <div class="form-options-item col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput(
                    ['class' => 'form-control', 'placeholder' => $placeholder]); ?>
            </div>

            <div class="col-md-5 col-sm-5 col-xs-8">
                <?= $form->field($modelData, '[0]comment')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-3">
                <a class="btn btn-primary btn-block showFileUpload">
                    <i class="glyphicon glyphicon-camera"></i>
                </a>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-3 deleteServiceDiv">
                <button type="button" class="delete-item btn btn-default">
                    <i class="glyphicon glyphicon-minus"></i>
                </button>
            </div>

            <?php if (isset($parts)) : ?>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <?= $form->field($modelData, '[0]condition')->checkboxButtonGroup(
                        CarData::$partsCondition, ['class' => 'buttonListPartsCondition']); ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 partsOriginal">
                    <?= $form->field($modelData, '[0]original')->checkboxButtonGroup(CarData::$partsOriginal); ?>
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
                        'previewFileType' => 'image',
                        'showRemove'      => false,
                        'showCaption' => false,
                        'showUpload' => false,
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
                <hr/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= Html::button($buttonText, ['class' => 'add-item btn btn-default btn-sm']); ?>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>

<?php
$js
    = <<<'EOD'
$(".option-value-img").on("filecleared", function(event) {
    var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    var id = event.target.id;
    var matches = id.match(regexID);
    if (matches && matches.length === 4) {
        var identifiers = matches[2].split("-");
        $("#optionvalue-" + identifiers[1] + "-deleteimg").val("1");
    }
});

EOD;

JuiAsset::register($this);
$this->registerJs($js);