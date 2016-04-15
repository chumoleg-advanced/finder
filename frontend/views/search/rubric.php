<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = Yii::t('title', 'Categories');
?>
<div class="container mainCont carBg">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo Html::a('К списку категорий', Url::toRoute('/site/index'), ['class' => 'autoRepair']);
            ?>
        </div>

        <?php 
        $images = [
            '/img/icons_repair/auto_repair1.svg',
            '/img/icons_repair/auto_repair2.svg',
            '/img/icons_repair/auto_repair3.svg',
            '/img/icons_repair/auto_repair4.svg',
            '/img/icons_repair/auto_repair5.svg',
            '/img/icons_repair/auto_repair6.svg',
            '/img/icons_repair/auto_repair7.svg',
            '/img/icons_repair/auto_repair8.svg',
        ];
        ?>

        <?php foreach ($rubrics as $k => $rubric) : ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a class="whiteCardSub" href="<?= Url::toRoute(['/search/form', 'id' => $rubric->id]); ?>">
                <div class="icons_repair">
                    <img src="<?= ArrayHelper::getValue($images, $k); ?>" class="img-responsive">
                </div>
                <h4><?= $rubric->name; ?></h4>
                <link class="rippleJS" />
            </a>
        </div>
        <?php endforeach; ?>
        <div class="col-md-12">
            <?php
            echo Html::a('На главную', Url::toRoute('/'), ['class' => 'goHome']);
            ?>
        </div>
    </div>
</div>

