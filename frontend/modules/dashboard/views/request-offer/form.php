<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\SearchFormGenerator;
use frontend\modules\dashboard\forms\RequestOfferForm;
use common\models\category\Category;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\assets\FormPartSearchAsset;

/** @var \common\models\requestOffer\MainRequestOffer $model */

FormPartSearchAsset::register($this);

$this->title = 'Заявка #' . $model->request->id;

$backUrl = Url::previous('requestList');
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
    $scenario = $model->request->rubric->category_id == Category::PARTS ? 'parts' : 'default';
    $form = SearchFormGenerator::getFormRequestOffer($scenario);

    $modelData = new RequestOfferForm();

    $dynamicParams = [
        'widgetContainer' => 'dynamicform_wrapper',
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

    if (empty($model->requestOffers)) {
        echo $this->render('_row', [
            'form'      => $form,
            'request'   => $model->request,
            'modelData' => $modelData
        ]);
    } else {
        foreach ($model->requestOffers as $i => $requestOffer) {
            $modelData = new RequestOfferForm();
            $modelData->attributes = $requestOffer->attributes;
            $modelData->companyId = $requestOffer->company_id;
            $modelData->id = $requestOffer->id;
            $modelData->imageData = $requestOffer->requestOfferImages;

            echo $this->render('_row', [
                'i' => $i,
                'form'      => $form,
                'request'   => $model->request,
                'modelData' => $modelData
            ]);
        }
    }

    DynamicFormWidget::end();
    ?>

    <div>&nbsp;</div>
    <div class="row">
        <div class="col-md-12">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
    </div>
    <?php $form->end(); ?>
</div>