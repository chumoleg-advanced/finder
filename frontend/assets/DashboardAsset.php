<?php

namespace app\assets;

use yii\web\AssetBundle;

class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/company.js',
            '/js/dashboard/request.js'
        ];

    public $depends
        = [
            'app\assets\AppAsset',
        ];
}
