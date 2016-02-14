<?php

namespace frontend\modules\ajax\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\notification\NotificationSetting;

class UserController extends Controller
{
    public function actionManageNotification()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $userId = (int)Yii::$app->user->id;
        $type = (int)Yii::$app->request->post('type');
        NotificationSetting::manage($userId, $type);

        return true;
    }
}