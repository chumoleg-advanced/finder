<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

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
        'brandLabel' => '
            <div class="svg">
                <svg width="40" height="40" viewBox="0 0 40 40">
                  <path d="M31.668,15.865 C31.658,11.633 30.002,7.651 27.005,4.652 C23.008,0.652 17.141,-0.933 11.693,0.516 C9.026,1.225 6.580,2.637 4.621,4.598 C1.638,7.583 0.002,11.557 0.012,15.788 C0.022,20.020 1.678,24.002 4.675,27.001 C8.672,31.001 14.539,32.586 19.987,31.137 C22.043,30.590 23.966,29.625 25.638,28.314 L37.308,39.994 L39.988,37.312 L28.316,25.631 C30.496,22.858 31.677,19.455 31.668,15.865 ZM24.367,24.360 C22.877,25.851 21.020,26.924 18.995,27.462 C14.853,28.564 10.392,27.360 7.355,24.319 C5.077,22.040 3.819,19.013 3.811,15.798 C3.803,12.582 5.047,9.561 7.313,7.293 C8.803,5.802 10.661,4.729 12.685,4.191 C16.828,3.089 21.288,4.293 24.326,7.334 C26.603,9.613 27.862,12.640 27.870,15.855 C27.878,19.071 26.634,22.092 24.367,24.360 ZM17.178,13.501 L21.456,12.364 L22.448,16.039 L18.170,17.176 L19.327,21.463 L15.660,22.438 L14.503,18.151 L10.225,19.289 L9.233,15.614 L13.511,14.477 L12.353,10.189 L16.020,9.214 L17.178,13.501 Z"/>
                </svg>
            </div>
            <div class="logo">
                <span class="search">Search</span><span class="place">place</span>
            </div>
        ',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);

    $menuItems = [];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Войти', 'url' => '#', 'options' => ['class' => 'loginButton']];

    } else {
        if (Yii::$app->user->can('accessToBackend')) {
            $menuItems[] = ['label' => 'Администрирование', 'url' => Url::toRoute('/backend')];
        }

        $menuItems[] = [
            'label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::$app->user->identity->email,
            'items' => [
                [
                    'label'       => 'Выход',
                    'url'         => Url::to('/auth/logout'),
                    'linkOptions' => ['data-method' => 'post']
                ]
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

    <?= Alert::widget(); ?>
    <?= $content; ?>
    
</div>

<footer class="footer">
    <div class="container">
        <div class="pull-left">
            <div class="logo">
                &copy; 
                <span class="search">Search</span><span class="place">place</span>
            </div> <?= date('Y'); ?>
        </div>
    </div>
</footer>

<?= $this->render('_login'); ?>
<?= $this->render('_register'); ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

