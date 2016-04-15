<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $js
        = [
            '/js/owl-carousel/owl.carousel.min.js',
            '/js/carousel.js',
        ];
    public $css
        = [
            '/js/owl-carousel/assets/owl.carousel.min.css',
            '/js/owl-carousel/assets/owl.theme.green.min.css'
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
