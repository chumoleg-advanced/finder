<?php

use frontend\forms\request\QueryArrayForm;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use common\components\CarData;
use kartik\helpers\Html;
use frontend\assets\FormPartSearchAsset;

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

    <div class="form-options-body partsSearch">
        <div class="row dynamicFormRow">
            <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
                <h1>Моя заявка</h1>
                <a class="delBtn pull-right delete-item">
                    Удалить
                    <div class="svg">
                        <svg width="14" height="14" viewBox="0 0 14 14">
                          <path d="M14.000,1.400 L12.600,-0.000 L7.000,5.600 L1.400,-0.000 L-0.000,1.400 L5.600,7.000 L-0.000,12.600 L1.400,14.000 L7.000,8.400 L12.600,14.000 L14.000,12.600 L8.400,7.000 L14.000,1.400 Z" class="cls-1"/>
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelData, '[0]description')->textInput([
                    'placeholder' => $placeholder,
                    'class'       => 'form-control descriptionQuery'
                ]); ?>

                <div class="btn-group-xs partsSide" style="display: block;">
                    <a match="лев" class="ajaxLink sideLeft" href="#">#левый</a>&nbsp;
                    <a match="прав" class="ajaxLink sideRight" href="#">#правый</a>&nbsp;
                    <a match="перед" class="ajaxLink" href="#">#передний</a>&nbsp;
                    <a match="зад" class="ajaxLink" href="#">#задний</a>&nbsp;
                    <a match="верх" class="ajaxLink" href="#">#верхний</a>&nbsp;
                    <a match="ниж" class="ajaxLink" href="#">#нижний</a>
                </div>
                
                <div class="clearfix"></div> 
                
                <?php if (isset($parts)) : ?>
                    <div class="pull-left">
                        <?= $form->field($modelData, '[0]partsCondition')->checkboxButtonGroup(CarData::$partsCondition, [
                            'class'       => 'btn-group buttonListPartsCondition',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                        ]); ?>
                    </div>
                    <div class="pull-left partsOriginal">
                        <?= $form->field($modelData, '[0]partsOriginal')->checkboxButtonGroup(CarData::$partsOriginal, [
                            'class'       => 'btn-group',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                        ]); ?>
                    </div>

                <?php endif; ?> 

                <div class="clearfix"></div> 

                <a class="btn btn-default svgBtn showFileUpload">
                    <div class="svg">
                        <svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 533.333 533.334">
                            <g>
                                <path d="M66.667,133.333v333.333h466.667V133.333H66.667z M500,411.111L433.333,300l-75.556,62.962L300,266.667L100,433.333
                                    V166.667h400V411.111z M133.333,250c0,27.614,22.386,50,50,50c27.615,0,50-22.386,50-50s-22.385-50-50-50
                                    C155.719,200,133.333,222.386,133.333,250z M466.667,66.667H0V400h33.333V100h433.333V66.667z"/>
                            </g>
                        </svg>
                    </div>
                    Загрузите фото
                </a>

                <div class="clearfix"></div> 

                <div class="uploadFilesBlock">
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
                <div class="clearfix"></div> 
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelData, '[0]comment')->textInput(
                    ['class' => 'form-control', 'placeholder' => 'Комментарий']); ?>
                
                <div class="clearfix"></div> 
                
                <?php if (isset($parts)) : ?>
                    <?= $this->render('_needleDelivery', ['form' => $form, 'model' => $model]); ?>
                <?php endif; ?> 
                <div class="clearfix"></div> 
            </div>

        </div>
    </div>
        
    <input type="hidden" class="add-item addItemToRequest" />
<?php DynamicFormWidget::end(); ?>