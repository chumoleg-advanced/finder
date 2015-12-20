<?php

namespace app\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\Url;

class PreLoadSettings implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        if (Yii::$app->user->can('accessToPersonalCabinet')) {
            $baseUrl = Url::to('/dashboard');
            Yii::$app->setHomeUrl($baseUrl);
            Yii::$app->urlManager->addRules(['/' => $baseUrl], false);

            Yii::$app->errorHandler->errorAction = Url::to($baseUrl . '/index/error');
        }
    }
}