<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

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
            'brandLabel' => 'Админка',
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        $menuItems = [
            [
                'label'   => 'Пользователи',
                'visible' => Yii::$app->user->can('accessToBackend'),
                'items'   => [
                    [
                        'label'   => 'Управление пользователями',
                        'url'     => Url::toRoute('/management/user/index'),
                        'visible' => Yii::$app->user->can('userManage')
                    ],
                    [
                        'label'   => 'Распределение ролей',
                        'url'     => Url::toRoute('/management/role/index'),
                        'visible' => Yii::$app->user->can('roleManage')
                    ],
                    [
                        'label'   => 'Управление доступом',
                        'url'     => Url::toRoute('/management/access/index'),
                        'visible' => Yii::$app->user->can('accessManage')
                    ],
                ]
            ],
            [
                'label'   => 'Организации',
                'url'     => Url::toRoute('/company/index'),
                'visible' => Yii::$app->user->can('accessToBackend'),
            ],
            [
                'label'   => 'Заявки',
                'url'     => Url::toRoute('/request/index'),
                'visible' => Yii::$app->user->can('accessToBackend'),
            ],
            [
                'label'   => 'Справочники',
                'visible' => Yii::$app->user->can('accessToBackend'),
                'items'   => [
                    ['label' => 'Автомобили', 'url' => ['/management/car/index']],
                    ['label' => 'Запчасти', 'url' => ['/management/auto-part/index']],
                ]
            ],
            ['label' => 'Перейти на сайт', 'url' => Url::to('/')],
        ];

        if (!Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => Yii::$app->user->identity->email,
                'items' => [
                    [
                        'label'       => 'Выход',
                        'url'         => Url::toRoute('/site/logout'),
                        'linkOptions' => ['data-method' => 'post']
                    ],
                ]
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