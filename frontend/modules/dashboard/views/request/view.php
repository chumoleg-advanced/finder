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

<?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>
    <div>&nbsp;</div>

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('request-detail', ['model' => $model]); ?>
        </div>
    </div>

<?php if (!empty($bestOffer)) : ?>
    <div>&nbsp;</div>
    <div class="row" id="bestRequestOffer">
        <legend>Лучшее предложение</legend>
    </div>

    <?= $this->render('_offerExtendedInfo', ['model' => $bestOffer, 'cssClass' => 'row', 'counter' => 0]); ?>

    <?php if (!empty($otherOffersDataProvider)) : ?>
        <div>&nbsp;</div>

        <div class="row">
            <legend>Предложения других организаций</legend>

            <?php Pjax::begin(); ?>
            <?= ListView::widget([
                'dataProvider' => $otherOffersDataProvider,
                'itemView'     => '_otherOfferRow'
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>