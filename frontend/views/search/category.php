<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use frontend\assets\OwlCarouselAsset;
use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

OwlCarouselAsset::register($this);
$this->registerJsFile('/js/carousel.js', ['depends' => [OwlCarouselAsset::className()]]);

$this->title = Yii::t('title', 'Categories');
?>

<div>&nbsp;</div>
<p class="lead">Выберите категорию:</p>
<div>&nbsp;</div>

<div class="row">
    <div id="owl-demo" class="owl-carousel owl-theme col-lg-4 col-sm-6 col-xs-12">
        <?php foreach (\common\models\category\Category::getList(true) as $id => $name) : ?>
            <div class="text-center">
                <a href="<?= Url::toRoute(['/search/category', 'id' => $id]); ?>">
                    <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 200, 200,
                        EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                        ['class' => 'img-responsive img-thumbnail', 'alt' => $name]
                    ); ?><br/>
                    <?= $name; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
