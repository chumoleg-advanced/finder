<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

use \yii\helpers\Url;
use himiklab\thumbnail\EasyThumbnailImage;
use yii\web\Cookie;

$this->title = Yii::t('title', 'Search');
?>

<div class="site-index">
    <div class="col-md-12 text-center">
        <?php
        $city = Yii::$app->getRequest()->getCookies()->getValue('city');

        if (empty($city)) {
            $info = new common\components\GeoIpInfo();
            $city = $info->getValue('city');

            $cookie = new Cookie([
                'name'   => 'city',
                'value'  => $city,
                'expire' => time() + 86400 * 365,
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
        ?>

        <h3>Ваш город: <?= $city; ?></h3>
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
