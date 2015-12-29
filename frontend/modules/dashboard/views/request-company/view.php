<?php

use yii\helpers\Url;

/** @var \common\models\request\Request $model */
/** @var \common\models\request\RequestOffer $bestOffer */
/** @var \common\models\request\RequestOffer[] $otherOffers */

$this->title = 'Заявка #' . $model->id;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request-company/free');
}
?>

<div class="news-index">
    <?= \yii\helpers\Html::a('Вернуться к списку', $backUrl,
        ['class' => 'btn btn-default']); ?>

    <div>&nbsp;</div>
    <legend><?= $this->title; ?></legend>
</div>