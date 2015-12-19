<?php

namespace app\assets;

use yii\web\AssetBundle;

class FormPartSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/partSearch.js',
            'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        ];

    public $depends
        = [
            'app\assets\AppAsset',
        ];
}
