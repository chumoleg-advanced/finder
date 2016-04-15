<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = Yii::t('title', 'Categories');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>&nbsp;</div>
            <p class="lead">Выберите категорию:</p>
            <div>&nbsp;</div>
        </div>
        <?php foreach (\common\models\category\Category::getList(true) as $id => $name) : ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a class="whiteCardSub" href="<?= Url::toRoute(['/search/category', 'id' => $id]); ?>">
                <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 200, 200,
                    EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                    ['class' => 'img-responsive img-thumbnail', 'alt' => $name]
                ); ?><br/>
                <?= $name; ?>
                <link class="rippleJS" />
            </a>
        </div>
        <?php endforeach; ?>
   </div>
</div>
