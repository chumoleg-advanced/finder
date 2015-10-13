<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div style="margin-top: 25vh;">
        <div class="lead col-lg-12 text-center">
            Введите запрос сюда
        </div>

        <div class="lead col-lg-12 col-md-12 col-xs-12 col-sm-12 col-md-offset-3 text-center">
            <?= \kartik\helpers\Html::textInput('searchField', null,
                ['class' => 'col-lg-6 col-md-6 col-xs-12 col-sm-12']); ?>
        </div>

        <div class="col-lg-12 text-center">
            <a class="btn btn-lg btn-success" href="<?= Url::toRoute('/site/search'); ?>">Поиск</a>
        </div>
    </div>
</div>
