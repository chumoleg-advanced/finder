<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl-carousel/owl-carousel';
    public $js
        = [
            'owl.carousel.min.js'
        ];
    public $css
        = [
            'owl.theme.css',
            'owl.carousel.css'
        ];

    public $depends
        = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
}
