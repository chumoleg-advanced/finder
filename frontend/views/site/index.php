<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div class="col-md-12 text-center">
        <?php $info = new common\components\GeoIpInfo(); ?>
        <h3>Ваш город: <?= $info->getValue('city'); ?></h3>
    </div>

    <div class="col-md-12 text-center">
        <?php foreach (\common\models\category\Category::getList(true) as $id => $name) : ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <a href="<?= Url::toRoute(['/search/category', 'id' => $id]); ?>">
                    <?= EasyThumbnailImage::thumbnailImg('img/NoImage.jpg', 400, 200,
                        EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                        ['class' => 'img-responsive img-thumbnail', 'alt' => $name]
                    ); ?><br/>
                    <?= $name; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
