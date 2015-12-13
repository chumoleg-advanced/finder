<?php

namespace frontend\modules\personalCabinet;

use common\components\Role;
use common\models\user\User;
use Yii;
use \yii\base\Module;
use yii\web\HttpException;

class PersonalCabinetModule extends Module
{
    public function init()
    {
        $this->controllerNamespace = 'frontend\modules\personalCabinet\controllers';
        $this->layout = '/personalCabinet';
        $this->defaultRoute = 'profile/index';

        if (Yii::$app->user->isGuest || User::getUserRole() != Role::USER) {
            throw new HttpException(403, 'Access denied');
        }

        parent::init();
    }
}
