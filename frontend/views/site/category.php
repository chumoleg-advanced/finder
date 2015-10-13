<?php

/* @var $this yii\web\View */

use \frontend\assets\OwlCarouselAsset;
use \yii\helpers\Url;

OwlCarouselAsset::register($this);
$this->registerJsFile('/js/carousel.js', ['depends' => [OwlCarouselAsset::className()]]);

$this->title = Yii::t('title', 'Categories');
?>

<div>&nbsp;</div>
<p class="lead">Выберите категорию:</p>
<div>&nbsp;</div>

<div class="row">
    <div id="owl-demo" class="owl-carousel owl-theme col-lg-12">
        <?php foreach ($categoryData as $categories) : ?>
            <?php /* @var $categories common\models\category\Category[] */ ?>
            <div class="item">
                <?php foreach ($categories as $category) : ?>
                    <div class="col-lg-4 col-xs-12 col-sm-6 text-center">
                        <a href="<?= Url::toRoute(['/site/category', 'id' => $category->id]); ?>">
                            <img src="/img/NoImage.jpg" class="img-responsive img-thumbnail"
                                 alt="<?= $category->name; ?>"/>
                            <?= $category->name; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
