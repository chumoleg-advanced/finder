<?php

use app\modules\dashboard\components\CompanyCreateForm;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\company\CompanyContactData;
use app\modules\dashboard\forms\company\ContactDataValues;

$this->title = 'Контактные данные';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = CompanyCreateForm::getForm($event->step, ['id' => 'contact-data-form']);

$modelValues = new ContactDataValues();
?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'address')->textInput(['class' => 'form-control deliveryAddress']); ?>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody'      => '.container-items',
                'widgetItem'      => '.item',
                'limit'           => 12,
                'min'             => 1,
                'insertButton'    => '.add-item',
                'deleteButton'    => '.remove-item',
                'model'           => $model,
                'formId'          => 'contact-data-form',
                'formFields'      => [
                    'type',
                    'value'
                ],
            ]);
            ?>

            <div class="form-group form-options-body">
                <div class="container-items">
                    <?php for ($i = 0; $i < 3; $i++) : ?>
                        <div class="row item">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <?php $modelValues->typeData[0] = $i + 1; ?>
                                <?= $form->field($modelValues, '[' . $i . ']typeData', [
                                    'template' => "{input}\n{hint}\n{error}"
                                ])->dropDownList(CompanyContactData::getGroupedTypeList()); ?>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($modelValues, '[' . $i . ']valueData', [
                                    'template' => "{input}\n{hint}\n{error}"
                                ])->textInput(['placeholder' => 'Введите значение ...']); ?>
                            </div>

                            <div class="col-md-1 col-sm-1 col-xs-6 text-right">
                                <a class="btn btn-default add-item">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                            </div>

                            <div class="col-md-1 col-sm-1 col-xs-6 text-right">
                                <?php if ($i > 0) : ?>
                                    <a class="btn btn-default remove-item">
                                        <i class="glyphicon glyphicon-minus"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>

            <?= $this->render('_buttons', ['visibleNext' => false, 'visibleDone' => true]); ?>
        </div>
    </div>
<?php
$form->end();
