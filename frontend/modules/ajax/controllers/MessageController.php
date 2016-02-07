<?php

namespace frontend\modules\ajax\controllers;

use common\models\Message;
use common\models\request\Request;
use common\models\requestOffer\RequestOffer;
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

    public function actionOpenRequestDialog()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $requestId = (int)Yii::$app->request->post('requestId');
        $requestOfferId = (int)Yii::$app->request->post('requestOfferId');
        if (empty($requestId) || empty($requestOfferId)) {
            return null;
        }

        $requestOffer = RequestOffer::findById($requestOfferId);

        Message::readMessage($requestId);

        $model = new Message();
        $model->to_user_id = $requestOffer->user_id;
        $model->request_id = $requestId;

        $dialogHistory = Message::getMessageListByRequest($model->request_id);

        $html = $this->renderPartial('requestDialog', [
            'model'         => $model,
            'dialogHistory' => $dialogHistory,
            'request'       => Request::findById($model->request_id)
        ]);

        return [
            'html'        => $html,
            'companyName' => $requestOffer->company->legal_name,
        ];
    }

    public function actionOpenMessageDialog()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $requestId = (int)Yii::$app->request->post('requestId');
        $toUserId = (int)Yii::$app->request->post('toUserId');
        if (empty($requestId)) {
            return null;
        }

        if (empty($toUserId)) {
            $requestModel = Request::findById($requestId);
            $toUserId = $requestModel->user_id;
        }

        Message::readMessage($requestId);

        $model = new Message();
        $model->to_user_id = $toUserId;
        $model->request_id = $requestId;

        return $this->renderPartial('requestDialog', [
            'showBack'      => true,
            'model'         => $model,
            'dialogHistory' => Message::getMessageListByRequest($model->request_id),
            'request'       => Request::findById($model->request_id)
        ]);
    }

    public function actionSendMessage()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $data = Yii::$app->request->post('Message');
        if (empty($data)) {
            return false;
        }

        $model = new Message();
        $model->attributes = $data;
        if ($model->save()) {
            $dialogHistory = Message::getMessageListByRequest($model->request_id);
            return $this->renderPartial('dialogHistory', [
                'dialogHistory' => $dialogHistory,
                'request'       => Request::findById($model->request_id)
            ]);
        }

        return false;
    }
}