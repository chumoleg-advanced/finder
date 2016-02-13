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

            <?php
            if (!empty($model->company->companyAddresses)) {
                $firstAddress = $model->company->companyAddresses[0];
                echo Html::hiddenInput('addressCoordinates', $firstAddress->map_coordinates,
                    ['class' => 'addressCoordinates']);

                echo Html::tag('div', '&nbsp;');

                echo 'Адрес: ' . $firstAddress->address . '<br />';
                foreach ($firstAddress->companyContactDatas as $contact) {
                    echo CompanyContactData::$typeList[$contact->type] . ': ' . $contact->data . '<br />';
                }

                echo Html::tag('div', '&nbsp;');

                $timeWork = $firstAddress->getTimeWorkDataAsString();
                if (!empty($timeWork)){
                    echo 'Время работы: <br />';
                    echo $timeWork;

                    echo Html::tag('div', '&nbsp;');
                }

                echo 'Способы доставки: <br />';
                $typeDeliveries = [];
                foreach ($model->company->companyTypeDeliveries as $typeDelivery) {
                    $typeDeliveries[] = CompanyTypeDelivery::$typeList[$typeDelivery->type];
                }

                echo implode(', ', $typeDeliveries);
            }
            ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-condensed table-bordered detail-view">
                    <tr>
                        <th>Описание</th>
                        <td><?= $model->description; ?></td>
                    </tr>
                    <tr>
                        <th>Комментарий</th>
                        <td><?= $model->comment; ?></td>
                    </tr>

                    <?php $deliveryDays = []; ?>
                    <?php foreach ($model->getAttributesData() as $attribute => $value) : ?>
                        <?php
                        if ($attribute == 'deliveryDayFrom' || $attribute == 'deliveryDayTo') {
                            $deliveryDays[$attribute] = $value;
                            continue;
                        }
                        ?>

                        <tr>
                            <th><?= ArrayHelper::getValue($offerAttributeLabels, $attribute); ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (!empty($deliveryDays)) : ?>
                        <tr>
                            <th>Срок доставки</th>
                            <td><?= ArrayHelper::getValue($deliveryDays, 'deliveryDayFrom'); ?> -
                                <?= ArrayHelper::getValue($deliveryDays, 'deliveryDayTo'); ?> дн.
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>

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