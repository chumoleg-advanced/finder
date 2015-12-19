<?php

namespace app\modules\dashboard;

use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\dashboard\controllers';

    public function init()
    {
        parent::init();

        $this->layout = 'main';
        \Yii::$app->errorHandler->errorAction = Url::to('/' . $this->id . '/index/error');
    }
}
