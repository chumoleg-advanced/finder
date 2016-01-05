<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
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
        'brandLabel' => 'My Company',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Авторизация', 'url' => '#', 'options' => ['class' => 'loginButton']];

    } else {
        if (Yii::$app->user->can('accessToBackend')) {
            $menuItems[] = ['label' => 'Администрирование', 'url' => Url::toRoute('/backend')];
        }

        $menuItems[] = [
            'label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::$app->user->identity->email,
            'items' => [
                ['label' => 'Профиль', 'url' => Url::to('/profile/index')],
                [
                    'label'       => 'Выход',
                    'url'         => Url::to('/auth/logout'),
                    'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ];
    }

    echo Nav::widget([
        'options'      => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items'        => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget(); ?>
        <?= $content; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y'); ?></p>

        <p class="pull-right"><?= Yii::powered(); ?></p>
    </div>
</footer>

<?= $this->render('_login'); ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

