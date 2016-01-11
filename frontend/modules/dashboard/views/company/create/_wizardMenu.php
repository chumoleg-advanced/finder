<?php
use frontend\modules\dashboard\components\CompanyWizardMenu;

?>

<div class="wizardMenu">
    <?= CompanyWizardMenu::widget([
        'step'        => $event->step,
        'wizard'      => $event->sender,
        'options'     => ['class' => 'col-md-12 col-sm-12 col-xs-12'],
        'itemOptions' => ['class' => 'col-md-4 col-sm-12 col-xs-12']
    ]); ?>
</div>