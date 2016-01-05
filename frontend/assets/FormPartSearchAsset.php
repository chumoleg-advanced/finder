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
        ];

    public $depends
        = [
            'app\assets\AppAsset',
        ];
}
