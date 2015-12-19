<?php

namespace app\assets;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@webroot/source/owl-carousel';

    public $js
        = [
            'owl.carousel.min.js'
        ];
    public $css
        = [
            'assets/owl.carousel.min.css',
            'assets/owl.theme.green.min.css'
        ];

    public $depends
        = [
            'app\assets\AppAsset',
        ];
}
