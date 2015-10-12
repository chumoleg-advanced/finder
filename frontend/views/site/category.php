<?php

/* @var $this yii\web\View */
/* @var $categories common\models\category\Category[] */

$this->title = 'My Yii Application';

\frontend\assets\OwlCarouselAsset::register($this);
$this->registerJsFile('/js/carousel.js', ['depends' => [\frontend\assets\OwlCarouselAsset::className()]]);
?>

<div>&nbsp;</div>
<p class="lead">Выберите категорию:</p>
<div>&nbsp;</div>

<div id="demo">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div id="owl-demo" class="owl-carousel owl-theme col-lg-12">
                    <?php $split = array_chunk($categories, 12); ?>
                    <?php foreach ($split as $categoryData) : ?>
                        <div class="item">
                            <?php foreach ($categoryData as $category) : ?>
                                <div class="col-lg-4 col-xs-12 col-sm-6" style="height: 150px; text-align: center;">
                                    <a href="/site/category/<?= $category->id; ?>">
                                        <?= $category->name; ?></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
