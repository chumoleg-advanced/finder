<?php

namespace frontend\components;

use common\components\Role;
use common\models\user\User;
use Yii;

/*
/* The base class that you use to retrieve the settings from the database
*/
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->user->isGuest && User::getUserRole(Yii::$app->user->getId()) == Role::USER) {
                $this->layout = 'personalCabinet';
            }

            return true;
        }

        return false;
    }
}