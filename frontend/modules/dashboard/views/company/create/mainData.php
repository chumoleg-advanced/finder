<?php
/** @var MainData $model */

use frontend\modules\dashboard\forms\company\MainData;
use frontend\modules\dashboard\components\CompanyCreateForm;
use frontend\assets\DashboardMainAsset;

DashboardMainAsset::register($this);

$this->title = 'Общая информация';

echo $this->render('_wizardMenu', ['event' => $event]);

if (empty($model->form)) {
    $model->form = MainData::FORM_JURIDICAL;
}
?>

<div class="row">
    <div class="col-md-6">
        <?php
        $form = CompanyCreateForm::getForm($event->step);
        echo $this->render('/company/common/mainData', ['form' => $form, 'model' => $model]);
        echo $this->render('_buttons', ['visiblePrev' => false]);
        $form->end();
        ?>
    </div>
</div>
