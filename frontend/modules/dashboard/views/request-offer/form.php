<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\SearchFormGenerator;
use frontend\modules\dashboard\forms\RequestOfferForm;
use common\models\category\Category;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\assets\FormPartSearchAsset;
use common\models\company\CompanyRubric;
use common\models\request\RequestAttribute;
use yii\helpers\ArrayHelper;
use common\components\CarData;


/** @var \common\models\requestOffer\MainRequestOffer $model */

FormPartSearchAsset::register($this);

$this->title = 'Заявка #' . $model->request->id;

$backUrl = Url::previous('requestOfferList');
if (empty($backUrl)) {
    $backUrl = Url::toRoute('request-offer/index');
}
?>

<?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>
<div>&nbsp;</div>

<?= $this->render('/request/request-detail', ['model' => $model->request]); ?>
<div>&nbsp;</div>

<div class="request-offer-form">
    <?php
    $service = $model->request->rubric->category_id == Category::SERVICE;
    $form = SearchFormGenerator::getFormRequestOffer();

    $modelData = new RequestOfferForm();

    $dynamicParams = [
        'widgetContainer' => 'requestOfferDynamicForm',
        'widgetBody'      => '.form-options-body',
        'widgetItem'      => '.dynamicFormRow',
        'min'             => 1,
        'insertButton'    => '.add-item',
        'deleteButton'    => '.delete-item',
        'model'           => $modelData,
        'formId'          => SearchFormGenerator::FORM_ID,
        'formFields'      => [
            'description',
            'comment'
        ],
    ];

    DynamicFormWidget::begin($dynamicParams);
    ?>

    <div class="form-options-body">
        <?php
        $companiesList = CompanyRubric::getCompaniesByRubric($model->request->rubric_id);
        $partsCondition = RequestAttribute::getValueByRequest($model->request->id, 'partsCondition');
        $partsOriginal = RequestAttribute::getValueByRequest($model->request->id, 'partsOriginal');
        $availability = CarData::$availability;

        $viewParams = [
            'availability'   => $availability,
            'companiesList'  => $companiesList,
            'partsCondition' => $partsCondition,
            'partsOriginal'  => $partsOriginal,
            'service'        => $service,
            'form'           => $form,
            'request'        => $model->request,
        ];

        if (empty($model->requestOffers)) {
            $modelData = new RequestOfferForm();
            $modelData->companyId = current(array_keys($companiesList));
            $modelData->availability = current(array_keys($availability));
            if (!empty($partsCondition)) {
                $modelData->partsCondition = current(array_keys($partsCondition));
            }

            if (!empty($partsOriginal)) {
                $modelData->partsOriginal = current(array_keys($partsOriginal));
            }

            echo $this->render('_row', ArrayHelper::merge([
                'modelData' => $modelData
            ], $viewParams));

        } else {
            foreach ($model->requestOffers as $i => $requestOffer) {
                $attributes = ArrayHelper::map($requestOffer->requestOfferAttributes, 'attribute_name', 'value');

                $modelData = new RequestOfferForm();
                $modelData->attributes = ArrayHelper::merge($requestOffer->attributes, $attributes);
                $modelData->companyId = $requestOffer->company_id;
                $modelData->id = $requestOffer->id;
                $modelData->imageData = $requestOffer->requestOfferImages;

                echo $this->render('_row', ArrayHelper::merge([
                    'i'         => $i,
                    'modelData' => $modelData
                ], $viewParams));
            }
        }
        ?>
    </div>

    <?php if (!$service) : ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить еще одно предложение',
                    ['class' => 'add-item btn btn-success btn-sm']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php DynamicFormWidget::end(); ?>

    <div>&nbsp;</div>
    <div class="row">
        <div class="col-md-12">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
    </div>
    <?php $form->end(); ?>
</div>