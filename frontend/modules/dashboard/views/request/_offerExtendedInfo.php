<?php
/** @var \common\models\requestOffer\RequestOffer $model */

use yii\helpers\Html;
use common\models\company\CompanyContactData;
use common\models\company\CompanyTypeDelivery;
use yii\helpers\ArrayHelper;
use frontend\modules\dashboard\forms\RequestOfferForm;

$offerAttributeLabels = (new RequestOfferForm())->attributeLabels();
?>

<div class="row <?= $cssClass; ?> requestOfferBlock" data-counter="<?= $counter; ?>">
    <div class="col-md-3">
        <div class="row">
            <h3>Цена: <?= $model->price; ?></h3>

            <h3><?= $model->company->legal_name; ?></h3>
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

                echo 'Способы доставки: <br />';
                foreach ($model->company->companyTypeDeliveries as $typeDelivery) {
                    echo CompanyTypeDelivery::$typeList[$typeDelivery->type] . '<br />';
                }
            }
            ?>
        </div>
    </div>

    <div class="col-md-6">
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

                    <?php foreach ($model->getAttributesData() as $attribute => $value) : ?>
                        <tr>
                            <th><?= ArrayHelper::getValue($offerAttributeLabels, $attribute); ?></th>
                            <td><?= $value; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <?php if (!empty($model->requestOfferImages)) : ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 imagesPreview">
                        <?php foreach ($model->requestOfferImages as $image) : ?>
                            <a class="fancybox imageBlock" rel="gallery_<?= $model->id; ?>"
                               href="<?= '/' . $image->name; ?>">
                                <img src="<?= '/' . $image->thumb_name; ?>" alt=""/>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div id="yandexMapCompany_<?= $counter; ?>" class="yandexMapCompany"></div>
    </div>
</div>