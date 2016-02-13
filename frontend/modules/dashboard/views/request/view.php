<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\DashboardRequestAsset;
use common\models\company\CompanyTypeDelivery;

DashboardRequestAsset::register($this);

/** @var \common\models\request\Request $model */
/** @var \common\models\requestOffer\RequestOffer $bestOffer */
/** @var \common\models\requestOffer\RequestOffer[] $otherOffers */

$this->title = 'Заявка №' . $model->id . '. ' . $model->description;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request/index');
}

echo Html::hiddenInput('requestId', $model->id, ['id' => 'requestId']);
?>

<?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>
    <div>&nbsp;</div>

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('request-detail', ['model' => $model]); ?>
        </div>
    </div>

<?php if (!empty($bestOffer)) : ?>
    <div>&nbsp;</div>
    <?php $counter = 1; ?>

    <div class="row" id="bestRequestOffer">
        <legend>Лучшее предложение</legend>
    </div>
    <?= $this->render('_offerExtendedInfo', ['model' => $bestOffer, 'cssClass' => 'row', 'counter' => $counter]); ?>

    <?php if (!empty($otherOffers)) : ?>
        <div>&nbsp;</div>

        <div class="row">
            <legend>Предложения других организаций</legend>

            <?php foreach ($otherOffers as $offer) : ?>
                <div class="dynamicFormRowView">
                    <div class="row">
                        <div class="col-md-4">
                            Компания: <?= $offer->company->actual_name; ?><br/>
                            <?= $offer->description; ?>
                        </div>

                        <div class="col-md-4">
                            <?php
                            foreach ($offer->company->companyTypeDeliveries as $typeDelivery) {
                                echo CompanyTypeDelivery::$typeList[$typeDelivery->type] . '<br />';
                            }
                            ?>
                        </div>

                        <div class="col-md-4">
                            Цена: <?= $offer->price; ?><br/>
                        </div>
                    </div>

                    <a href="javascript:;" class="btn btn-sm btn-default viewMainOfferInfo">Посмотреть предложение</a>

                    <div class="row">
                        <div class="col-md-12">
                            <div>&nbsp;</div>
                            <?= $this->render('_offerExtendedInfo', [
                                'model'    => $offer,
                                'cssClass' => 'mainOfferInfoBlock',
                                'counter'  => ++$counter
                            ]); ?>
                        </div>
                    </div>
                </div>

                <div>&nbsp;</div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>