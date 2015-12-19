<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\components\Controller;

class SettingController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}