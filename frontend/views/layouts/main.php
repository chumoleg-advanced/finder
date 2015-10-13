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
use yii\bootstrap\Modal;

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
        'brandLabel' => 'My Company',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => Url::toRoute('/site/index')],
        ['label' => 'About', 'url' => Url::toRoute('/site/about')],
        ['label' => 'Contact', 'url' => Url::toRoute('/site/contact')],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => Url::toRoute('/site/signup')];
        $menuItems[] = ['label' => 'Login', 'url' => '#', 'options' => ['class' => 'loginButton']];
    } else {
        $menuItems[] = [
            'label'   => Yii::t('frontend/title', 'Personal cabinet'),
            'url'     => ['/personalCabinet/index/index'],
            'visible' => Yii::$app->user->can('accessToPersonalCabinet'),
            'items'   => [
                ['label' => 'Персональные данные', 'url' => ['/personalCabinet/index/index']],
                ['label' => 'Компании', 'url' => ['/personalCabinet/company/index']],
                ['label' => 'Расчетные счета', 'url' => ['/personalCabinet/settlement-account/index']],
            ]
        ];

        $menuItems[] = [
            'label'       => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url'         => Url::toRoute('/site/logout'),
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?= $this->render('login'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

