<?php
use common\models\company\CompanyTypeDelivery;

/** @var \common\models\requestOffer\RequestOffer $model */
?>

<div class="dynamicFormRowView">
    <div class="row">
        <div class="col-md-4">
            Компания: <?= $model->company->actual_name; ?><br/>
            <?= $model->description; ?>
        </div>

        <div class="col-md-4">
            <?php
            foreach ($model->company->companyTypeDeliveries as $typeDelivery) {
                echo CompanyTypeDelivery::$typeList[$typeDelivery->type] . '<br />';
            }
            ?>
        </div>

        <div class="col-md-4">
            Цена: <?= $model->price; ?><br/>
        </div>
    </div>

    <a href="javascript:;" class="btn btn-sm btn-default viewMainOfferInfo">Посмотреть предложение</a>

    <div class="row">
        <div class="col-md-12">
            <div>&nbsp;</div>
            <?= $this->render('_offerExtendedInfo', [
                'model'    => $model,
                'cssClass' => 'mainOfferInfoBlock',
                'counter'  => $model->id
            ]); ?>
        </div>
    </div>
</div>

<div>&nbsp;</div>