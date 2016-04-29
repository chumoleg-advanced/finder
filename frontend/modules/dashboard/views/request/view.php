<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\DashboardRequestAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

DashboardRequestAsset::register($this);

/** @var \common\models\request\Request $model */
/** @var \common\models\requestOffer\RequestOffer $bestOffer */
/** @var \common\models\requestOffer\RequestOffer[] $otherOffers */

$this->title = 'Заявка №' . $model->id . '. ' . $model->description;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request/index');
}

echo Html::hiddenInput('requestId', $model->id, ['id' => 'requestId']);
?>
<div class="container mainCont">
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('Вернуться к списку', $backUrl, ['class' => 'autoRepair']); ?>
        </div>
    </div>
    <div class="dynamicFormRow">
        <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
            <h1><?= Html::encode($this->title); ?></h1>
            <a class="pull-right collapseBtn" type="button" data-toggle="collapse" data-target="#requestInfoView" aria-expanded="true" aria-controls="requestInfoView">
                <span class="rollUp">Свернуть</span>
                <span class="chevron"></span>
            </a>
        </div>
        <div class="dynamicFormRowBody collapse in requestInfo" id="requestInfoView">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?= $this->render('request-detail', ['model' => $model]); ?>
            </div>
        </div>
    </div>

    <?php if (!empty($bestOffer)) : ?>
        <div class="dynamicFormRow">
            <div class="col-md-12 col-sm-12 col-xs-12 myRequest">
                <h1><?= Html::encode($this->title); ?></h1>
            </div>
            <div class="dynamicFormRowBody">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= $this->render('_offerExtendedInfo', ['model' => $bestOffer, 'cssClass' => 'row', 'counter' => 0]); ?>
                </div>
            </div>
        </div>

        <?php if (!empty($otherOffersDataProvider)) : ?>
            <?php Pjax::begin(); ?>
            <?= ListView::widget([
                'dataProvider' => $otherOffersDataProvider,
                'itemView'     => '_otherOfferRow',
                'layout'     => '{items}',
            ]);
            ?>
            <?php Pjax::end(); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>