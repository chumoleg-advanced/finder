<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\components\Controller;

class RequestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate($id)
    {
        return $this->render('create');
    }
}