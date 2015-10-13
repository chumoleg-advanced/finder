<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div style="margin-top: 25vh;">
        <div class="col-lg-12 text-center">
            <a class="btn btn-lg btn-success" href="<?= Url::toRoute('/site/search'); ?>">Перейти к поиску!</a>
        </div>
    </div>
</div>
