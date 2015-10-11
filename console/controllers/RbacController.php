<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\components\RbacManager;

class RbacController extends Controller
{
    public function actionGenerate()
    {
        $model = new RbacManager();
        $model->generate();
    }
}