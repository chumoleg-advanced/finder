<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div style="margin-top: 25vh;">
        <div class="col-md-12 text-center">
            <?php foreach ($categories as $category) : ?>
                <div class="col-md-6">
                    <a href="<?= Url::toRoute(['/search/category', 'id' => $category->id]); ?>">
                        <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 400, 200,
                            EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                            ['class' => 'img-responsive img-thumbnail', 'alt' => $category->name]
                        ); ?><br/>
                        <?= $category->name; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
