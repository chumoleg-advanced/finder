<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use \frontend\assets\OwlCarouselAsset;
use \yii\helpers\Url;
use \yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

OwlCarouselAsset::register($this);
$this->registerJsFile('/js/carousel.js', ['depends' => [OwlCarouselAsset::className()]]);

$this->title = Yii::t('title', 'Categories');

echo Html::a('К списку категорий', Url::toRoute('/site/index'));
echo Html::tag('div', '&nbsp;');
?>

<div>&nbsp;</div>
<p class="lead">Выберите рубрику:</p>
<div>&nbsp;</div>

<div class="row">
    <div id="owl-demo" class="owl-carousel owl-theme col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($rubrics as $rubric) : ?>
            <a href="<?= Url::toRoute(['/search/form', 'id' => $rubric->id]); ?>">
                <div class="text-center">
                    <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 300, 300,
                        EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                        ['class' => 'img-responsive img-thumbnail', 'alt' => $rubric->name]
                    ); ?><br/>
                    <?= $rubric->name; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
