<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\DashboardRequestAsset;
use common\models\company\CompanyContactData;
use frontend\modules\dashboard\forms\RequestOfferForm;

DashboardRequestAsset::register($this);


/** @var \common\models\request\Request $model */
/** @var \common\models\requestOffer\RequestOffer $bestOffer */
/** @var \common\models\requestOffer\RequestOffer[] $otherOffers */

$this->title = 'Заявка #' . $model->id . '. ' . $model->description;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request/index');
}

echo Html::hiddenInput('requestId', $model->id, ['id' => 'requestId']);

$offerAttributeLabels = (new RequestOfferForm())->attributeLabels();
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
    <div class="row">
        <div class="col-md-4">
            <div id="yandexMapCompany"></div>
        </div>
        <div class="col-md-8">
            <legend>Лучшее предложение</legend>
            <div class="row">
                <div class="col-md-6">
                    <h3>Стоимость: <?= $bestOffer->price; ?></h3>
                </div>

                <div class="col-md-6">
                    <h3><?= $bestOffer->company->actual_name; ?></h3>
                    <?php
                    if (!empty($bestOffer->company->companyAddresses)) {
                        $firstAddress = $bestOffer->company->companyAddresses[0];
                        echo Html::hiddenInput('addressCoordinates', $firstAddress->map_coordinates,
                            ['class' => 'addressCoordinates']);

                        echo 'Адрес: ' . $firstAddress->address . '<br />';
                        foreach ($firstAddress->companyContactDatas as $contact) {
                            echo CompanyContactData::$typeList[$contact->type] . ': '
                                . $contact->data . '<br />';
                        }
                    }
                    ?>
                </div>
            </div>

            <div>&nbsp;</div>
            <?= $this->render('_rowOffer', ['model' => $bestOffer, 'labels' => $offerAttributeLabels]); ?>
        </div>
    </div>

    <?php if (!empty($otherOffers)) : ?>
        <div>&nbsp;</div>
        <div class="row">
            <div class="col-md-12">
                <legend>Предложения других организаций</legend>

                <?php foreach ($otherOffers as $offer) : ?>
                    <div class="row">
                        <div class="col-md-8">
                            Компания: <?= $offer->company->actual_name; ?><br/>
                            <?= $offer->description; ?>
                        </div>

                        <div class="col-md-4">
                            Цена: <?= $offer->price; ?><br/>
                        </div>
                    </div>

                    <?= $this->render('_rowOffer', ['model' => $offer, 'labels' => $offerAttributeLabels]); ?>
                    <div>&nbsp;</div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>