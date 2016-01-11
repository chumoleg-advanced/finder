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
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
