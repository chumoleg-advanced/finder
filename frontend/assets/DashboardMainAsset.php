<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class DashboardMainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/main.js',
            '/js/dashboard/message.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
