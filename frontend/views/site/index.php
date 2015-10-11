<?php

/* @var $this yii\web\View */

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div style="margin-top: 25vh;">
        <div class="lead col-lg-12 text-center">
            Введите запрос сюда
        </div>

        <div class="lead col-md-12 col-md-offset-3 text-center">
            <?= \kartik\helpers\Html::textInput('searchField', null, ['class' => 'col-md-6']); ?>
        </div>

        <div class="col-lg-12 text-center">
            <a class="btn btn-lg btn-success" href="/site/search">Поиск</a>
        </div>
    </div>
</div>
