<?php

use \frontend\assets\OwlCarouselAsset;
use himiklab\thumbnail\EasyThumbnailImage;

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

$this->title = 'My Yii Application';

OwlCarouselAsset::register($this);
$this->registerJsFile('/js/carousel.js', ['depends' => [OwlCarouselAsset::className()]]);
?>

<div>&nbsp;</div>
<p class="lead">Выберите категорию:</p>
<div>&nbsp;</div>

<div id="demo">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div id="owl-demo" class="owl-carousel owl-theme col-lg-12">
                    <?php foreach ($categoryData as $categories) : ?>
                        <div class="item">
                            <?php foreach ($categories as $category) : ?>
                                <div class="col-lg-4 col-xs-12 col-sm-6" style="height: 150px; text-align: center;">

                                    <a href="/site/category/<?= $category->id; ?>">
                                        <?php echo EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 150, 100); ?>
                                        <br/>
                                        <?= $category->name; ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
