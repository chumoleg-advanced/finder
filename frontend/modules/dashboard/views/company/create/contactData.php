<?php

use frontend\modules\dashboard\components\CompanyCreateForm;

$this->title = 'Контактные данные';

echo $this->render('_wizardMenu', ['event' => $event]);

$form = CompanyCreateForm::getForm($event->step, ['id' => 'company-data-form']);
?>
    <div class="row">
        <div class="col-md-8">
            <?= $this->render('/company/common/addressData', ['form' => $form, 'model' => $model]); ?>
            <?= $this->render('/company/common/contactData', ['form' => $form, 'model' => $model]); ?>
        </div>
    </div>

<?= $this->render('_buttons', ['visibleNext' => false, 'visibleDone' => true]); ?>

<?php
$form->end();
