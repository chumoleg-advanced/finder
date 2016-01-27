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
use common\models\request\Request;

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

<?= $this->render('/request/request-detail', ['model' => $model->request, 'viewToggleLink' => true]); ?>
<div>&nbsp;</div>

<div class="request-offer-form">
    <?php
    $service = $model->request->rubric->category_id == Category::SERVICE;
    $form = SearchFormGenerator::getFormRequestOffer();
    ?>

    <div class="form-options-body">
        <?php
        $companiesList = CompanyRubric::getCompaniesByRubric($model->request->rubric_id);

        $availability = CarData::$availability;
        $attributesList = [
            'partsCondition',
            'partsOriginal',
            'discType',
            'tireType',
            'tireTypeWinter'
        ];

        $offerFormAttributes = [];
        foreach ($attributesList as $attributeName) {
            $offerFormAttributes[$attributeName] = RequestAttribute::getValueByRequest(
                $model->request->id, $attributeName);
        }

        $viewParams = ArrayHelper::merge([
            'availability'  => $availability,
            'companiesList' => $companiesList,
            'service'       => $service,
            'form'          => $form,
            'request'       => $model->request,
        ], $offerFormAttributes);

        if (empty($model->requestOffers)) {
            $modelData = new RequestOfferForm();
            $modelData->companyId = current(array_keys($companiesList));
            $modelData->availability = current(array_keys($availability));

            foreach ($offerFormAttributes as $attributeName => $valueFromRequest) {
                if (empty($valueFromRequest)) {
                    continue;
                }

                $modelData->{$attributeName} = is_array($valueFromRequest)
                    ? current(array_keys($valueFromRequest)) : $valueFromRequest;
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

    <?php if (!$service && !$requestClosed) : ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить еще одно предложение',
                    ['class' => 'add-item btn btn-success btn-sm']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!$requestClosed) : ?>
        <div>&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php $form->end(); ?>
</div>