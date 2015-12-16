<?php

namespace frontend\components;

use common\components\Role;
use common\models\user\User;
use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\Url;

class Settings implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $baseUrl = Url::to('/cabinet');
        if (!Yii::$app->user->isGuest && User::getUserRole(Yii::$app->user->getId()) == Role::USER) {
            Yii::$app->setHomeUrl($baseUrl);
        }
    }
}