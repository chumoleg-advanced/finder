<?php

namespace app\assets;

use yii\web\AssetBundle;

class DashboardMainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/main.js',
        ];

    public $depends
        = [
            'app\assets\AppAsset',
        ];
}
