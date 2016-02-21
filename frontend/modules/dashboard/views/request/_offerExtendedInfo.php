<?php
/** @var \common\models\requestOffer\RequestOffer $model */

use yii\helpers\Html;
use common\models\company\CompanyContactData;
use common\models\company\CompanyTypeDelivery;
use yii\helpers\ArrayHelper;
use frontend\modules\dashboard\forms\RequestOfferForm;

$offerAttributeLabels = (new RequestOfferForm())->attributeLabels();
?>

<div class="<?= $cssClass; ?> requestOfferBlock" data-counter="<?= $counter; ?>">
    <div class="col-md-4">
        <div class="row">
            <h3>Цена: <?= $model->price; ?></h3>

            <h3><?= $model->company->actual_name; ?></h3>
            <a href="javascript:;" class="sendMessageFromRequest" data-offer="<?= $model->id; ?>">
                Связаться с компанией</a>

            <div>&nbsp;</div>

            <?php if (!empty($model->company->companyAddresses)) : ?>
                <?php
                $firstAddress = $model->company->companyAddresses[0];
                $timeWork = $firstAddress->getTimeWorkDataAsString();

                $typeDeliveries = [];
                foreach ($model->company->companyTypeDeliveries as $typeDelivery) {
                    $typeDeliveries[] = CompanyTypeDelivery::$typeList[$typeDelivery->type];
                }

                echo Html::hiddenInput('addressCoordinates', $firstAddress->map_coordinates,
                    ['class' => 'addressCoordinates']);
                ?>
                <div>&nbsp;</div>

                <strong>Адрес</strong>: <?= $firstAddress->address; ?><br/>
                <?php foreach ($firstAddress->companyContactDatas as $contact) : ?>
                    <strong><?= CompanyContactData::$typeList[$contact->type]; ?></strong>: <?= $contact->data; ?><br/>
                <?php endforeach; ?>

                <div>&nbsp;</div>

                <?php if (!empty($timeWork)) : ?>
                    <strong>Время работы</strong>:<br/>
                    <?= $timeWork; ?>
                    <div>&nbsp;</div>
                <?php endif; ?>

                <strong>Способы доставки</strong>:<br/>
                <?= implode(', ', $typeDeliveries); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <strong>Описание</strong>:<br/>
                <?= $model->description; ?>
                <div>&nbsp;</div>

                <?php if (!empty($model->comment)) : ?>
                    <strong>Комментарий</strong>:<br/>
                    <?= $model->comment; ?>
                    <div>&nbsp;</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php $deliveryDays = []; ?>
            <?php foreach ($model->getAttributesData() as $attribute => $value) : ?>
                <?php
                if ($attribute == 'deliveryDayFrom' || $attribute == 'deliveryDayTo') {
                    $deliveryDays[$attribute] = $value;
                    continue;
                }
                ?>

                <div class="col-md-6 requestOfferAttributeBlock">
                    <strong><?= ArrayHelper::getValue($offerAttributeLabels, $attribute); ?></strong>:<br/>
                    <?= $value; ?>
                </div>
            <?php endforeach; ?>

            <?php if (!empty($deliveryDays)) : ?>
                <div class="col-md-6 requestOfferAttributeBlock">
                    <strong>Срок доставки</strong>:<br/>
                    <?= ArrayHelper::getValue($deliveryDays, 'deliveryDayFrom'); ?> -
                    <?= ArrayHelper::getValue($deliveryDays, 'deliveryDayTo'); ?> дн.
                </div>
            <?php endif; ?>

        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($model->requestOfferImages)) : ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 imagesPreview">
                        <?php foreach ($model->requestOfferImages as $image) : ?>
                            <a class="fancybox imageBlock" rel="gallery_<?= $model->id; ?>"
                               href="<?= '/' . $image->name; ?>">
                                <img src="<?= '/' . $image->thumb_name; ?>" alt="gallery"/>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div id="yandexMapCompany_<?= $counter; ?>" class="yandexMapCompany"></div>
    </div>
</div>