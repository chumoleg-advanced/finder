<?php

namespace frontend\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;

class MessageController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}