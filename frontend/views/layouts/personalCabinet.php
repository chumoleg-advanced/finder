<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'Личный кабинет',
            'brandUrl'   => Url::to('personalCabinet'),
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        $menuItems = [
            [
                'label' => '<i class="glyphicon glyphicon-plus"></i> Создать заявку',
                'url'   => Url::toRoute('/personalCabinet/request/create')
            ],
            ['label' => 'Мои заявки', 'url' => Url::toRoute('/personalCabinet/request/index')],
            ['label' => 'Мои организации', 'url' => Url::toRoute('/personalCabinet/company/index')],
            [
                'label' => '<i class="glyphicon glyphicon-bell"></i>',
                'url'   => Url::toRoute('/personalCabinet/message/index')
            ],
            [
                'label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::$app->user->identity->username,
                'items' => [
                    ['label' => 'Профиль', 'url' => ['/personalCabinet/profile/index']],
                    [
                        'label'       => 'Выход',
                        'url'         => Url::toRoute('/site/logout'),
                        'linkOptions' => ['data-method' => 'post']
                    ],
                ]
            ]
        ];

        echo Nav::widget([
            'options'      => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items'        => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]); ?>
            <?= Alert::widget(); ?>
            <?= $content; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>