<?php

namespace app\modules\ajax;

use Yii;
use \yii\base\Module;
use yii\web\HttpException;

class AjaxModule extends Module
{
    public $controllerNamespace = 'app\modules\ajax\controllers';

    public function init()
    {
        if (!Yii::$app->request->isAjax){
            throw new HttpException(403, 'Access denied');
        }

        parent::init();
    }
}
