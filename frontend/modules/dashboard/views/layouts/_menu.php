<?php

use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use frontend\modules\dashboard\components\MenuItems;
use kartik\helpers\Html;

NavBar::begin([
    'brandLabel' => Html::img('@web/img/Drawing.png', ['alt' => Yii::$app->name]),
    'brandUrl'   => Yii::$app->getHomeUrl(),
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo NavX::widget([
    'options'         => ['class' => 'navbar-nav'],
    'items'           => MenuItems::getItems(),
    'activateParents' => true,
    'encodeLabels'    => false
]);

NavBar::end();