<?php

/** @var \common\models\request\Request $model */

use frontend\assets\DashboardRequestAsset;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

use common\models\car\CarFirm;
use common\models\car\CarModel;
use common\models\car\CarBody;
use common\models\car\CarEngine;
use common\components\CarData;

DashboardRequestAsset::register($this);

$mainData = $model->mainRequest->data;
?>

<a href="javascript:;" class="requestInfoView">Информация по заявке</a>

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
            <legend>Информация о доставке</legend>
            <?= ArrayHelper::getValue($mainData, 'deliveryAddress'); ?>

            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <legend>Изображения</legend>
            <?php foreach ($model->requestImages as $requestImage) : ?>
                <a class="fancybox imageBlock" rel="gallery1" href="<?= '/' . $requestImage->name; ?>">
                    <img src="<?= '/' . $requestImage->thumb_name; ?>" alt=""/>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="col-md-6">
            <?php $carBrand = CarFirm::getNameById(ArrayHelper::getValue($mainData, 'carFirm')); ?>
            <?php if (!empty($carBrand)) : ?>
                <?php
                $carModel = CarModel::getNameById(ArrayHelper::getValue($mainData, 'carModel'));
                $carBody = CarBody::getNameById(ArrayHelper::getValue($mainData, 'carBody'));
                $carEngine = CarEngine::getNameById(ArrayHelper::getValue($mainData, 'carEngine'));
                ?>
                <legend>Для автомобиля</legend>

                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th>Марка</th>
                        <td><?= $carBrand; ?></td>
                    </tr>
                    <tr>
                        <th>Модель</th>
                        <td><?= $carModel; ?></td>
                    </tr>
                    <tr>
                        <th>Кузов</th>
                        <td><?= $carBody; ?></td>
                    </tr>
                    <tr>
                        <th>Двигатель</th>
                        <td><?= $carEngine; ?></td>
                    </tr>
                </table>
            <?php endif; ?>

            <legend>Дополнительная информация</legend>
            <table class="table table-striped table-bordered detail-view">
                <tr>
                    <th>VIN или FRAME</th>
                    <td><?= ArrayHelper::getValue($mainData, 'vinNumber'); ?></td>
                </tr>
                <tr>
                    <th>Год выпуска</th>
                    <td><?= ArrayHelper::getValue($mainData, 'yearRelease'); ?></td>
                </tr>
                <tr>
                    <th>Привод</th>
                    <td><?= ArrayHelper::getValue(CarData::$driveList,
                            ArrayHelper::getValue($mainData, 'drive')); ?></td>
                </tr>
                <tr>
                    <th>Коробка передач</th>
                    <td><?= ArrayHelper::getValue(CarData::$transmissionList,
                            ArrayHelper::getValue($mainData, 'transmission')); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div>&nbsp;</div>
