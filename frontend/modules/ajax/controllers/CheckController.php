<?php

namespace frontend\modules\ajax\controllers;

use Yii;
use yii\web\Controller;
use \yii\web\Response;

class CheckController extends Controller
{
    public function actionUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $status = !Yii::$app->user->isGuest ? true : false;
        return ['status' => $status];
    }
}