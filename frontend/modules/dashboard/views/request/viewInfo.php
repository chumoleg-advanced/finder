<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\DashboardMainAsset;

DashboardMainAsset::register($this);

/** @var \common\models\request\Request $model */

$this->title = 'Заявка #' . $model->id;

$backUrl = Url::previous('requestList');
if (empty($backUrl)) {
    $backUrl = Url::to('/dashboard/request/index');
}
?>

<div class="news-index">
    <?= Html::a('Вернуться к списку', $backUrl, ['class' => 'btn btn-default']); ?>

    <div>&nbsp;</div>
    <legend><?= $this->title; ?></legend>

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('request-detail', ['model' => $model]); ?>
        </div>
    </div>
</div>