<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FormPartSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/partSearch.js',
            'http://api-maps.yandex.ru/2.1/?lang=ru_RU',
            '/js/yandexMap.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
