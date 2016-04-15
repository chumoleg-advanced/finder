<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css
        = [
            'css/reset.min.css',
            'css/font-awesome/css/font-awesome.min.css',
            'css/style.css',
        ];

    public $js
        = [
            '/js/ripple.min.js',
            '/js/jquery.onoff.min.js',
            '/js/main.js',
        ];
    
    public $depends
        = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
            'yii\jui\JuiAsset'
        ];
}
