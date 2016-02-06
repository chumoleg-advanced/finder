<?php

namespace frontend\modules\ajax\controllers;

use common\models\Message;
use Yii;
use yii\web\Controller;
use \yii\web\Response;

class MessageController extends Controller
{
    public function actionGetDialogList()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $data = Message::getDialogList();

        return $this->renderPartial('dialogList', ['data' => $data]);
    }
}