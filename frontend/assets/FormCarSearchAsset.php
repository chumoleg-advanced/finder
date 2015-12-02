<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FormCarSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/carSearch.js'
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
