<?php

/** @var \common\models\request\Request $model */
/** @var yii\web\View $this */

use frontend\assets\DashboardRequestAsset;
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use common\models\request\RequestAttribute;

DashboardRequestAsset::register($this);

$formModelClass = $model->rubric->geFormModelClassName();
$formModel = new $formModelClass();

$requestAttributes = $model->getRequestAttributesData();
$carData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_CAR);
$wheelData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_WHEEL);
$partData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_PART);
$priceData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_PRICE);
$deliveryData = RequestAttribute::getValuesByGroup($requestAttributes, $formModel, RequestAttribute::GROUP_DELIVERY);

echo Html::hiddenInput('requestId', $model->id, ['id' => 'requestId']);
?>

<!-- <a href="javascript:;" class="requestInfoView">Скрыть информацию по заявке</a> -->

<div class="col-md-6 col-sm-6 col-xs-12">
    <h5 class="titleF17">Запрос</h5>
    <div class="dotItemBox">
        <div class="dotItem">
            <div class="diLabel"><?= $model->getAttributeLabel('category'); ?></div>
            <div class="diValue"><?= \common\helpers\CategoryHelper::getNameByCategory($model->category); ?></div>
        </div>
        <div class="dotItem">
            <div class="diLabel"><?= $model->getAttributeLabel('rubric_id'); ?></div>
            <div class="diValue"><?= !empty($model->rubric) ? $model->rubric->name : null; ?></div>
        </div>
        <div class="dotItem">
            <div class="diLabel"><?= $model->getAttributeLabel('description'); ?></div>
            <div class="diValue"><?= $model->description; ?></div>
        </div>
        <div class="dotItem">
            <div class="diLabel"><?= $model->getAttributeLabel('comment'); ?></div>
            <div class="diValue"><?= $model->comment; ?></div>
        </div>
        <div class="dotItem">
            <div class="diLabel"><?= $model->getAttributeLabel('date_create'); ?></div>
            <div class="diValue"><?= date('Y-m-d', strtotime($model->date_create)); ?></div>
        </div>
    </div>

    <?php if (!empty($partData)) : ?>
        <div class="clearfix"></div>

        <h5 class="titleF17">Дополнительная информация</h5>

        <div class="dotItemBox">
            <?php foreach ($partData as $label => $value) : ?>
                <div class="dotItem">
                    <div class="diLabel"><?= $label; ?></div>
                    <div class="diValue"><?= $value; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($model->requestImages)) : ?>
        <div class="clearfix"></div>

        <h5 class="titleF17">Изображения</h5>
        
        <?php foreach ($model->requestImages as $requestImage) : ?>
                <a class="fancybox imageBlock" rel="gallery1" href="<?= '/' . $requestImage->name; ?>">
                    <img src="<?= '/' . $requestImage->thumb_name; ?>" alt="gallery" class="img-responsive thumbnail" />
                </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
    <?php if (!empty($carData)) : ?>
        <h5 class="titleF17">Для автомобиля</h5>

        <div class="dotItemBox">
            <?php foreach ($carData as $label => $value) : ?>
                <div class="dotItem">
                    <div class="diLabel"><?= $label; ?></div>
                    <div class="diValue"><?= $value; ?></div>
                </div>
            <?php endforeach; ?>
            <?php if (!empty($priceData)) : ?>
                <div class="dotItem">
                    <div class="diLabel">Цена</div>
                    <div class="diValue"><?= implode(' - ', array_values($priceData)) . ' руб.'; ?></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($wheelData)) : ?>
        <div class="clearfix"></div>

        <h5 class="titleF17">Параметры шины/диска</h5>

        <div class="dotItemBox">
            <?php foreach ($wheelData as $label => $value) : ?>
                <div class="dotItem">
                    <div class="diLabel"><?= $label; ?></div>
                    <div class="diValue"><?= $value; ?></div>
                </div>
            <?php endforeach; ?>
            <?php if (!empty($priceData)) : ?>
                <div class="dotItem">
                    <div class="diLabel">Цена</div>
                    <div class="diValue"><?= implode(' - ', array_values($priceData)) . ' руб.'; ?></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($deliveryData)) : ?>
        <div class="clearfix"></div>

        <h5 class="titleF17">Информация о доставке</h5>
        
        <div class="dotItemBox">
            <div class="dotItem">
                <div class="diLabel">Адрес</div>
                <div class="diValue"><?= $deliveryData['deliveryAddress']; ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?= Html::hiddenInput('addressCoordinatesRequest', $deliveryData['addressCoordinates'],
            ['id' => 'addressCoordinatesRequest']); ?>
        <div class="yandexMapRequest" id="yandexMapRequest"></div>
    <?php endif; ?>
</div>