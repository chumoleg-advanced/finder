<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;
use \yii\helpers\Html;

$this->title = Yii::t('title', 'Search');
?>

<div class="row" style="margin-top: 20vh;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3">
            <?= Html::textInput('searchField', null,
                ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
                 'placeholder' => 'Введите запрос ...']); ?>
        </div>

        <div>&nbsp;</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a class="btn btn-lg btn-success" href="<?= Url::toRoute('/site/result'); ?>">
                Отправить запрос</a>
        </div>
</div>
