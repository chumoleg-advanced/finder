<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class YandexMapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
