<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use common\models\company\Company;

/** @var \common\models\request\Request $model */
/** @var \common\models\request\RequestOffer $formModel */

$this->title = 'Заявка #' . $model->id;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request-company/free');
}
?>

<div class="news-index">
    <?= \yii\helpers\Html::a('Вернуться к списку', $backUrl,
        ['class' => 'btn btn-default']); ?>

    <div>&nbsp;</div>
    <legend><?= $this->title; ?></legend>

    <div class="company-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($formModel, 'price')->textInput(); ?>
        <?= $form->field($formModel, 'delivery_price')->textInput(); ?>
        <?= $form->field($formModel, 'description')->textInput(); ?>
        <?= $form->field($formModel, 'company_id')->dropDownList(Company::getListByUser()); ?>

        <div class="form-group">
            <?= common\helpers\ButtonHelper::getSubmitButton($model); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>