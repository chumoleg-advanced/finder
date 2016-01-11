<?php

namespace frontend\assets;

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
            'frontend\assets\AppAsset',
            'frontend\assets\YandexMapAsset'
        ];

    public $jsOptions = ['position' => View::POS_END];
}
