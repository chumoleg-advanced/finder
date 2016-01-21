<?php

namespace frontend\modules\dashboard;

use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\dashboard\controllers';

    public function init()
    {
        parent::init();

        $this->layout = 'main';
        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            Yii::$app->errorHandler->errorAction = Url::to('/' . $this->id . '/index/error');
        }
    }
}
