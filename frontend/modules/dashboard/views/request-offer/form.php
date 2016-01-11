<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use common\models\request\RequestOffer;

/** @var \common\models\request\RequestOffer $formModel */

$model = $formModel->request;

$this->title = 'Заявка #' . $model->id;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::toRoute('request-offer/index');
}
?>

<?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>
<div>&nbsp;</div>

<?= $this->render('/request/request-detail', ['model' => $model]); ?>

<div class="company-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if ($formModel->status == RequestOffer::STATUS_NEW) : ?>

        <?= $form->field($formModel, 'price')->textInput(); ?>
        <?= $form->field($formModel, 'delivery_price')->textInput(); ?>
        <?= $form->field($formModel, 'description')->textInput(); ?>
        <?= $form->field($formModel, 'company_id')->dropDownList(
            \common\models\company\CompanyRubric::getCompaniesByRubric($model->rubric_id)); ?>

        <div class="form-group">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
        <?php $form->end(); ?>
    <?php endif; ?>

    <?php if ($formModel->status == RequestOffer::STATUS_ACTIVE) : ?>
        <legend>Предложение</legend>
        <?= \yii\widgets\DetailView::widget([
            'model'      => $formModel,
            'attributes' => [
                'price',
                'delivery_price',
                'description',
                [
                    'attribute' => 'date_create',
                    'format'    => 'date',
                ],
            ]
        ]); ?>
    <?php endif; ?>
</div>