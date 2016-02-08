<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\SearchFormGenerator;
use frontend\modules\dashboard\forms\RequestOfferForm;
use common\models\category\Category;
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

<a href="javascript:;" class="rowRequestMessage" data-offer-id="<?= $model->id; ?>">Связаться с клиентом</a>
<div>&nbsp;</div>

<?= Html::hiddenInput('requestId', $model->request_id, ['id' => 'requestId']); ?>
<?= $this->render('/request/request-detail', ['model' => $model->request]); ?>
<div>&nbsp;</div>

<div class="request-offer-form">
    <?php $form = SearchFormGenerator::getFormParamsRequestOffer(); ?>
    <?php $service = $model->request->rubric->category_id == Category::SERVICE; ?>

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
            'widgetItem'      => '.dynamicFormRow',
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
            <legend>Добавьте еще предложений</legend>
            <?= $this->render('_row', $viewParams); ?>
        </div>
    <?php } ?>

    <div>&nbsp;</div>

    <?php if (!$service && !$requestClosed) : ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Добавить еще одно предложение',
                    ['class' => 'addItemRequestOffer btn btn-success btn-sm']); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if ($dynamic) {
        DynamicFormWidget::end();
    }
    ?>

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