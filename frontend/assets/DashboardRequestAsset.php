<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class DashboardRequestAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/request.js',
        ];

    public $depends
        = [
            'app\assets\AppAsset',
            'app\assets\YandexMapAsset'
        ];

    public $jsOptions = ['position' => View::POS_END];
}
