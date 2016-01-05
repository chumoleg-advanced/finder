<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\DashboardMainAsset;
use app\assets\DashboardRequestAsset;
use common\models\company\CompanyContactData;

DashboardMainAsset::register($this);
DashboardRequestAsset::register($this);


/** @var \common\models\request\Request $model */
/** @var \common\models\request\RequestOffer $bestOffer */
/** @var \common\models\request\RequestOffer[] $otherOffers */

$this->title = 'Заявка #' . $model->id;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request/index');
}

echo Html::hiddenInput('requestId', $model->id, ['id' => 'requestId']);
?>

<div class="news-index">
    <?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>

    <div>&nbsp;</div>
    <legend><?= $this->title; ?></legend>

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('request-detail', ['model' => $model]); ?>
        </div>
    </div>
    <div>&nbsp;</div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <div id="yandexMap"></div>
            </div>
            <div class="col-md-9">
                <legend>Лучшее предложение</legend>
                <?php if (!empty($bestOffer)) : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Стоимость: <?= $bestOffer->price; ?></h3>

                            <h3>Доставка: <?= $bestOffer->delivery_price; ?></h3>
                        </div>

                        <div class="col-md-6">
                            <h3><?= $bestOffer->company->actual_name; ?></h3>
                            <?php
                            foreach ($bestOffer->company->companyAddresses as $address) {
                                echo 'Адрес: ' . $address->address . '<br />';
                                foreach ($address->companyContactDatas as $contact) {
                                    echo CompanyContactData::$typeList[$contact->type] . ': '
                                        . $contact->data . '<br />';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div>&nbsp;</div>

                    <div class="row">
                        <div class="col-md-12">
                            <a href="javascript:;" class="viewMainOfferInfo">Посмотреть предложение</a>

                            <div class="mainOfferInfoBlock" style="display: none;">
                                <?= $bestOffer->description; ?>
                            </div>
                        </div>
                    </div>

                <?php else : ?>
                    Пока предложений не было!
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div>&nbsp;</div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-9">
                <legend>Предложения других организаций</legend>
                <?php if (!empty($otherOffers)) : ?>
                    <?php foreach ($otherOffers as $offer) : ?>
                        <div class="row">
                            <div class="col-md-8">
                                Компания: <?= $offer->company->actual_name; ?><br/>
                                <?= $offer->description; ?>
                            </div>

                            <div class="col-md-4">
                                Цена: <?= $offer->price; ?><br/>
                                Доставка: <?= $offer->delivery_price; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else : ?>
                    Пока предложений не было!
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>