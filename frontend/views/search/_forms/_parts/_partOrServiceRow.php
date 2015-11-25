<?php

use \frontend\searchForms\QueryArrayForm;
use yii\jui\JuiAsset;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use \common\components\CarData;
use \kartik\helpers\Html;
use \kartik\typeahead\Typeahead;
use \yii\helpers\Url;

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

$modelData = new QueryArrayForm();
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
                <?php if (isset($parts)) : ?>
                    <?= $form->field($modelData, '[0]description')->widget(Typeahead::className(), [
                        'options'       => ['placeholder' => $placeholder, 'class' => 'form-control descriptionQuery'],
                        'pluginOptions' => ['highlight' => false, 'minLength' => 2],
                        'dataset'       => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display'        => 'value',
                                'remote'         => [
                                    'url'      => Url::to(['search/parts-list']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ]); ?>
                <?php else: ?>
                    <?= $form->field($modelData, '[0]description')->textInput(
                        ['class' => 'form-control descriptionQuery', 'placeholder' => $placeholder]); ?>
                <?php endif; ?>
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
                <div class="col-md-12 col-sm-12 col-xs-12 checkBoxGroupFormBlock">
                    <div class="col-md-5 col-sm-6 col-xs-12 text-center">
                        <div inline="" data-toggle="buttons" class="btn-group-xs checkBoxGroupForm btn-group"
                             id="partSide">
                            <label class="btn btn-link"><input type="checkbox" data-value="1">слева</label>
                            <label class="btn btn-link">-</label>
                            <label class="btn btn-link"><input type="checkbox" data-value="2">справа</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;

                        <div inline="" data-toggle="buttons" class="btn-group-xs checkBoxGroupForm btn-group"
                             id="partDirection">
                            <label class="btn btn-link"><input type="checkbox" data-value="1">спереди</label>
                            <label class="btn btn-link">-</label>
                            <label class="btn btn-link"><input type="checkbox" data-value="2">сзади</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;

                        <div inline="" data-toggle="buttons" class="btn-group-xs checkBoxGroupForm btn-group"
                             id="partHeight">
                            <label class="btn btn-link"><input type="checkbox" data-value="1">сверху</label>
                            <label class="btn btn-link">-</label>
                            <label class="btn btn-link"><input type="checkbox" data-value="2">снизу</label>
                        </div>
                    </div>
                </div>
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