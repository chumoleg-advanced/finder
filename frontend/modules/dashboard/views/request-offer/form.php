<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\SearchFormGenerator;
use frontend\modules\dashboard\forms\RequestOfferForm;
use frontend\assets\FormPartSearchAsset;
use common\models\request\Request;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var \common\models\requestOffer\MainRequestOffer $model */
/** @var \yii\web\View $this */

FormPartSearchAsset::register($this);

$this->title = 'Заявка №' . $model->request->id . '. ' . $model->request->description;

$backUrl = Url::previous('requestOfferList');
if (empty($backUrl)) {
    $backUrl = Url::toRoute('request-offer/index');
}
?>
<div class="container mainCont dashboard">
    <div class="dynamicFormRow">
    <div class="dynamicFormRowBody">

        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>
        </div>

        <?php
        $requestClosed = false;
        if ($model->request->status == Request::STATUS_CLOSED) {
            $requestClosed = true;
        }
        ?>

        <?php if ($requestClosed) : ?>
            <div class="text-error text-bold">Заявка закрыта клиентом!</div>
            <div>&nbsp;</div>
        <?php endif; ?>
        
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="javascript:;" class="btn btn-default svgBtn rowRequestMessage" data-offer="<?= $model->id; ?>">
                <div class="svg">
                    <svg width="21" height="21" viewBox="0 0 21 21">
                      <path d="M19.950,4.200 L17.850,4.200 L17.850,13.650 L4.200,13.650 L4.200,15.750 C4.200,16.380 4.620,16.800 5.250,16.800 L16.800,16.800 L21.000,21.000 L21.000,5.250 C21.000,4.620 20.580,4.200 19.950,4.200 ZM15.750,10.500 L15.750,1.050 C15.750,0.420 15.330,-0.000 14.700,-0.000 L1.050,-0.000 C0.420,-0.000 -0.000,0.420 -0.000,1.050 L-0.000,15.750 L4.200,11.550 L14.700,11.550 C15.330,11.550 15.750,11.130 15.750,10.500 Z"/>
                    </svg>
                </div>
                Связаться с клиентом
            </a>
        </div>
        
        <div class="clearfix"></div>

        <?= Html::hiddenInput('requestId', $model->request_id, ['id' => 'requestId']); ?>
        <?= $this->render('/request/request-detail', ['model' => $model->request]); ?>
        <div>&nbsp;</div>

        <div class="request-offer-form">
            <?php $form = SearchFormGenerator::getFormParamsRequestOffer(); ?>
            <?php $service = ($model->request->category == \common\helpers\CategoryHelper::CATEGORY_SERVICE); ?>

            <?php
            $dynamic = false;
            $viewParams = RequestOfferForm::getAttributesDataByRequest($model->request, $form);
            if (empty($model->requestOffers)) {
                echo $this->render('_row', $viewParams);

            } else {
                foreach ($model->requestOffers as $requestOffer) {
                    echo $this->render('_rowView', ['requestOffer' => $requestOffer, 'service' => $service]);
                }

                $modelData = new RequestOfferForm();

                $dynamicParams = [
                    'widgetContainer' => 'requestOfferDynamicForm',
                    'widgetBody'      => '.form-options-body',
                    'widgetItem'      => '.dynamicForm',
                    'min'             => 1,
                    'insertButton'    => '.addItemRequestOffer',
                    'deleteButton'    => '.deleteItem',
                    'model'           => $modelData,
                    'formId'          => SearchFormGenerator::FORM_ID,
                    'formFields'      => [
                        'description',
                        'comment'
                    ],
                ];

                DynamicFormWidget::begin($dynamicParams);
                $dynamic = true;
                ?>

                <div class="form-options-body">
                    <div class="col-xs-12">
                        <h5 class="titleF17">Добавьте еще предложений</h5>
                    </div>
                    <?= $this->render('_row', $viewParams); ?>
                </div>
            <?php } ?>


            <?php if (!$service && !$requestClosed) : ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить еще одно предложение',
                        ['class' => 'addItemRequestOffer btn btn-success btn-sm']); ?>
                </div>
            <?php endif; ?>
            <?php
            if ($dynamic) {
                DynamicFormWidget::end();
            }
            ?>

            <?php if (!$requestClosed) : ?>
                <div class="col-md-12">
                    <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
                </div>
            <?php endif; ?>
            <?php $form->end(); ?>
        </div>
    </div>
    </div>
</div>