<?php

use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use app\modules\dashboard\components\MenuItems;
use kartik\helpers\Html;
use yii\widgets\Pjax;

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