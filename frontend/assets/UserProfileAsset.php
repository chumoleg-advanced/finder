<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class UserProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/profile.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
        ];
}
