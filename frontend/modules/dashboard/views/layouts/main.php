<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\widgets\Alert;
use frontend\assets\DashboardMainAsset;

DashboardMainAsset::register($this);
?>
<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <link rel="icon" href="/favicon.ico">
    <?php $this->head(); ?>
</head>
<body>
    <?php $this->beginBody(); ?>

    <div class="wrap">
        <?= $this->render('_menu'); ?>
        <?= Alert::widget(); ?>
        <?= $content; ?>

        <?= $this->render('_message'); ?>
    </div>

    <footer class="footer">
        <div class="container"></div>
    </footer>

    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
