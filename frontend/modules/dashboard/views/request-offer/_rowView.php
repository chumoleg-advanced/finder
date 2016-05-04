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

<div class="dynamicFormRowView dynamicFormRowViewOffer">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="dotItemBox">
            <div class="dotItem">
                <div class="diLabel"><?= $priceLabel; ?>:</div>
                <div class="diValue"><?= $requestOffer->price; ?> руб.</div>
            </div>
            <div class="dotItem">
                <div class="diLabel">Компания:</div>
                <div class="diValue"><?= $requestOffer->company->actual_name; ?></div>
            </div>
            <div class="dotItem">
                <div class="diLabel"><?= $descriptionLabel; ?>:</div>
                <div class="diValue"><?= $requestOffer->description; ?></div>
            </div>
            <div class="dotItem">
                <div class="diLabel">Комментарий:</div>
                <div class="diValue"><?= $requestOffer->comment; ?></div>
            </div>
        </div>
    </div>

    <?php if (!$service) : ?>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="dotItemBox">
                <div class="dotItem">
                    <?php $availability = ArrayHelper::getValue($attributes, 'availability'); ?>
                    <div class="diLabel">Наличие:</div>
                    <div class="diValue"><?= ArrayHelper::getValue(CarData::$availability, $availability); ?></div>
                </div>
                <?php if ($availability == 2) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Срок:</div>
                        <div class="diValue">
                            <?= ArrayHelper::getValue($attributes, 'deliveryDayFrom'); ?> -
                            <?= ArrayHelper::getValue($attributes, 'deliveryDayTo'); ?> дн.
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php
                $partsCondition = ArrayHelper::getValue($attributes, 'partsCondition');
                $partsOriginal = ArrayHelper::getValue($attributes, 'partsOriginal');
                $discType = ArrayHelper::getValue($attributes, 'discType');
                $tireType = ArrayHelper::getValue($attributes, 'tireType');
                $tireTypeWinter = ArrayHelper::getValue($attributes, 'tireTypeWinter');
                ?>

                <?php if (!empty($partsCondition)) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Состояние:</div>
                        <div class="diValue"><?= ArrayHelper::getValue(CarData::$partsCondition, $partsCondition); ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($partsOriginal)) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Оригинальность:</div>
                        <div class="diValue"><?= ArrayHelper::getValue(CarData::$partsOriginal, $partsOriginal); ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($discType)) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Тип дисков:</div>
                        <div class="diValue"><?= ArrayHelper::getValue(CarData::$discTypeList, $discType); ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tireType)) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Тип шин:</div>
                        <div class="diValue"><?= ArrayHelper::getValue(CarData::$tireTypeList, $tireType); ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tireTypeWinter)) : ?>
                    <div class="dotItem">
                        <div class="diLabel">Тип зимних шин:</div>
                        <div class="diValue"><?= ArrayHelper::getValue(CarData::$tireTypeWinterList, $tireTypeWinter); ?></div>
                    </div>
                <?php endif; ?>
            </div>


        </div>
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="javascript:;" class="btn btn-default copyRequestOffer" data-id="<?= $requestOffer->id; ?>">
                <i class="glyphicon glyphicon-copy"></i>
            </a>
        </div>
    <?php endif; ?>


    <?php if (!empty($requestOffer->requestOfferImages)) : ?>
        <div class="col-md-12 col-sm-12 col-xs-12 imagesPreview">
            <?php foreach ($requestOffer->requestOfferImages as $image) : ?>
                <a class="fancybox imageBlock" rel="gallery_<?= $requestOffer->id; ?>"
                   href="<?= '/' . $image->name; ?>">
                    <img src="<?= '/' . $image->thumb_name; ?>" alt="gallery"/>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>