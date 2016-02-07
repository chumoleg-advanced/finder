<?php

/** @var \common\models\request\Request $model */
/** @var yii\web\View $this */

use frontend\assets\DashboardRequestAsset;
use yii\widgets\DetailView;
use yii\helpers\Html;

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

<a href="javascript:;" class="requestInfoView">Скрыть информацию по заявке</a>

<div class="requestInfo">
    <div class="row well">
        <div class="col-md-6">
            <legend>Запрос</legend>

            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    [
                        'attribute' => 'categoryId',
                        'value'     => !empty($model->rubric) ? $model->rubric->category->name : null
                    ],
                    [
                        'attribute' => 'rubric_id',
                        'value'     => !empty($model->rubric) ? $model->rubric->name : null
                    ],
                    'description',
                    'comment',
                    [
                        'attribute' => 'date_create',
                        'format'    => 'date',
                    ],
                ]
            ]);
            ?>
            <div>&nbsp;</div>

            <?php if (!empty($partData)) : ?>
                <legend>Дополнительная информация</legend>
                <table class="table table-striped table-condensed table-bordered detail-view">
                    <?php foreach ($partData as $label => $value) : ?>
                        <tr>
                            <th><?= $label; ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div>&nbsp;</div>
            <?php endif; ?>

            <?php if (!empty($model->requestImages)) : ?>
                <legend>Изображения</legend>
                <?php foreach ($model->requestImages as $requestImage) : ?>
                    <div class="col-md-6">
                        <a class="fancybox imageBlock" rel="gallery1" href="<?= '/' . $requestImage->name; ?>">
                            <img src="<?= '/' . $requestImage->thumb_name; ?>" alt="gallery"/>
                        </a>
                    </div>
                <?php endforeach; ?>
                <div>&nbsp;</div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <?php if (!empty($carData)) : ?>
                <legend>Для автомобиля</legend>

                <table class="table table-striped table-condensed table-bordered detail-view">
                    <?php foreach ($carData as $label => $value) : ?>
                        <tr>
                            <th><?= $label; ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div>&nbsp;</div>
            <?php endif; ?>

            <?php if (!empty($wheelData)) : ?>
                <legend>Параметры шины/диска</legend>

                <table class="table table-striped table-condensed table-bordered detail-view">
                    <?php foreach ($wheelData as $label => $value) : ?>
                        <tr>
                            <th><?= $label; ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div>&nbsp;</div>
            <?php endif; ?>

            <?php if (!empty($priceData)) : ?>
                <legend>Цена</legend>
                <table class="table table-striped table-condensed table-bordered detail-view">
                    <?php foreach ($priceData as $label => $value) : ?>
                        <tr>
                            <th><?= $label; ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <div>&nbsp;</div>
            <?php endif; ?>

            <?php if (!empty($deliveryData)) : ?>
                <legend>Информация о доставке</legend>
                <b>Адрес:</b> <?= $deliveryData['deliveryAddress']; ?>
                <div>&nbsp;</div>
                <?= Html::hiddenInput('addressCoordinatesRequest', $deliveryData['addressCoordinates'],
                    ['id' => 'addressCoordinatesRequest']); ?>
                <div id="yandexMapRequest"></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div>&nbsp;</div>
