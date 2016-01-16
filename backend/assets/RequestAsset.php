<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class RequestAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/request.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
            'newerton\fancybox\FancyBoxAsset'
        ];

    public $jsOptions = ['position' => View::POS_END];
}
