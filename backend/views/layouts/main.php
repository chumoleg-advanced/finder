<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::t('title', 'System'),
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        $menuItems = [
            [
                'label'   => Yii::t('title', 'Login'),
                'url'     => ['/site/login'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label'   => Yii::t('title', 'Users'),
                'visible' => Yii::$app->user->can('accessToBackend'),
                'items'   => [
                    [
                        'label'   => Yii::t('title', 'Users management'),
                        'url'     => ['/management/user/index'],
                        'visible' => Yii::$app->user->can('userManage')
                    ],
                    [
                        'label'   => Yii::t('title', 'Roles management'),
                        'url'     => ['/management/role/index'],
                        'visible' => Yii::$app->user->can('roleManage')
                    ],
                    [
                        'label'   => Yii::t('title', 'Access rules'),
                        'url'     => ['/management/access/index'],
                        'visible' => Yii::$app->user->can('accessManage')
                    ],
                ]
            ]
        ];

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label'       => Yii::t('common/app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                'url'         => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::t('common/app', 'Billing Partner System') . ' ' . date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>