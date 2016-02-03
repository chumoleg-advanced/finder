<?php

/** @var \common\models\requestOffer\RequestOffer $requestOffer */

use yii\helpers\ArrayHelper;
use common\components\CarData;

$attributes = ArrayHelper::map($requestOffer->requestOfferAttributes, 'attribute_name', 'value');

$descriptionLabel = 'Описание работы';
$priceLabel = 'Стоимость работы';
if (!$service) {
    $descriptionLabel = 'Название запчасти или OEM-номер';
    $priceLabel = 'Цена';
}
?>

<div class="row dynamicFormRowView">
    <div class="col-md-5 col-sm-5 col-xs-12">
        <b><?= $descriptionLabel; ?></b>:
        <?= $requestOffer->description; ?>
    </div>

    <div class="col-md-5 col-sm-5 col-xs-12">
        <b>Комментарий</b>:
        <?= $requestOffer->comment; ?>
    </div>

    <div class="form-group"></div>

    <?php if (!empty($requestOffer->requestOfferImages)) : ?>
        <div class="col-md-12 col-sm-12 col-xs-12 imagesPreview">
            <?php foreach ($requestOffer->requestOfferImages as $image) : ?>
                <a class="fancybox imageBlock" rel="gallery_<?= $requestOffer->id; ?>"
                   href="<?= '/' . $image->name; ?>">
                    <img src="<?= '/' . $image->thumb_name; ?>" alt=""/>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="col-md-2 col-sm-2 col-xs-6">
        <div class="row">
            <div class="col-md-12">
                <b><?= $priceLabel; ?></b>:
                <?= $requestOffer->price; ?>
            </div>
            <div class="col-md-12">
                <b>Компания</b>:
                <?= $requestOffer->company->legal_name; ?>
            </div>
        </div>
    </div>

    <?php if (!$service) : ?>
        <div class="col-md-5 col-sm-5 col-xs-6">
            <?php $availability = ArrayHelper::getValue($attributes, 'availability'); ?>
            <b>Наличие</b>:
            <?= ArrayHelper::getValue(CarData::$availability, $availability); ?>

            <?php if ($availability == 2) : ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <b>Срок</b>:
                        от <?= ArrayHelper::getValue($attributes, 'deliveryDayFrom'); ?>
                        до <?= ArrayHelper::getValue($attributes, 'deliveryDayTo'); ?> дней
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-5 col-sm-5 col-xs-6">
            <div class="row">
                <?php
                $partsCondition = ArrayHelper::getValue($attributes, 'partsCondition');
                $partsOriginal = ArrayHelper::getValue($attributes, 'partsOriginal');
                $discType = ArrayHelper::getValue($attributes, 'discType');
                $tireType = ArrayHelper::getValue($attributes, 'tireType');
                $tireTypeWinter = ArrayHelper::getValue($attributes, 'tireTypeWinter');
                ?>

                <?php if (!empty($partsCondition)) : ?>
                    <div class="col-md-12">
                        <b>Состояние</b>:
                        <?= ArrayHelper::getValue(CarData::$partsCondition, $partsCondition); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($partsOriginal)) : ?>
                    <div class="col-md-12">
                        <b>Оригинальность</b>:
                        <?= ArrayHelper::getValue(CarData::$partsOriginal, $partsOriginal); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($discType)) : ?>
                    <div class="col-md-12">
                        <b>Тип дисков</b>:
                        <?= ArrayHelper::getValue(CarData::$discTypeList, $discType); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tireType)) : ?>
                    <div class="col-md-12">
                        <b>Тип шин</b>:
                        <?= ArrayHelper::getValue(CarData::$tireTypeList, $tireType); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tireTypeWinter)) : ?>
                    <div class="col-md-12">
                        <b>Тип зимних шин</b>:
                        <?= ArrayHelper::getValue(CarData::$tireTypeWinterList, $tireTypeWinter); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-12 col-sm-12 col-xs-12 boldBorderBottom">
    </div>
</div>