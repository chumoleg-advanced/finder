<?php

namespace backend\components;

use Yii;

class Controller extends \yii\web\Controller
{
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->can('accessToBackend')) {
            $this->redirect('/');
        }
    }
}