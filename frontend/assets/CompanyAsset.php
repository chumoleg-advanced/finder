<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CompanyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js
        = [
            '/js/dashboard/company.js',
        ];

    public $depends
        = [
            'frontend\assets\AppAsset',
            'yii\widgets\MaskedInputAsset'
        ];
}
