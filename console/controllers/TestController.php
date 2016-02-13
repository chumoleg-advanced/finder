<?php

namespace console\controllers;

use common\models\message\MessageDialog;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionClearMessage()
    {
        Yii::$app->db->createCommand()->delete(MessageDialog::tableName())->execute();
    }
}