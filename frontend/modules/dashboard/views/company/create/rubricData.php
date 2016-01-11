<?php

use frontend\modules\dashboard\components\CompanyCreateForm;
use frontend\assets\DashboardMainAsset;

DashboardMainAsset::register($this);

$this->title = 'Сфера деятельности';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = CompanyCreateForm::getForm($event->step);
?>

<?= $this->render('/company/common/rubricData', ['form' => $form, 'model' => $model]); ?>
    <div>&nbsp;</div>

<?= $this->render('/company/common/typePayment', ['form' => $form, 'model' => $model]); ?>
    <div>&nbsp;</div>

<?= $this->render('/company/common/typeDelivery', ['form' => $form, 'model' => $model]); ?>
    <div>&nbsp;</div>

<?php
echo $this->render('_buttons');

$form->end();
