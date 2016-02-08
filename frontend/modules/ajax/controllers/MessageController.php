<?php

namespace frontend\modules\ajax\controllers;

use common\models\message\Message;
use common\models\message\MessageDialog;
use common\models\request\Request;
use common\models\requestOffer\MainRequestOffer;
use common\models\requestOffer\RequestOffer;
use Yii;
use yii\web\Controller;
use \yii\web\Response;

class MessageController extends Controller
{
    public function actionGetDialogList()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $data = MessageDialog::getDialogList();
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
        $messageDialog = MessageDialog::getByRequestAndCompany($requestId,
            $requestOffer->company_id, $requestOffer->user_id);

        Message::readMessage($messageDialog->id);

        $model = new Message();
        $model->to_user_id = $requestOffer->user_id;
        $model->message_dialog_id = $messageDialog->id;

        $html = $this->renderPartial('requestDialog', [
            'model'         => $model,
            'messageDialog' => $messageDialog
        ]);

        return [
            'html'        => $html,
            'companyName' => $requestOffer->company->legal_name,
        ];
    }

    public function actionOpenMessageDialog()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $dialogId = (int)Yii::$app->request->post('dialogId');
        $mainRequestOfferId = (int)Yii::$app->request->post('mainRequestOfferId');
        if (empty($dialogId) && empty($mainRequestOfferId)) {
            return false;
        }


        if (!empty($dialogId)) {
            $messageDialog = MessageDialog::findById($dialogId);
        } else {
            $offerModel = MainRequestOffer::findById($mainRequestOfferId);
            $company = $offerModel->user->companies[0];
            $messageDialog = MessageDialog::getByRequestAndCompany($offerModel->request_id,
                $company->id, $offerModel->request->user_id, MessageDialog::SENDER_COMPANY);
        }

        Message::readMessage($dialogId);

        $model = new Message();
        $model->to_user_id = Yii::$app->user->id != $messageDialog->to_user_id
            ? $messageDialog->to_user_id : $messageDialog->from_user_id;
        $model->message_dialog_id = $messageDialog->id;

        $html = $this->renderPartial('requestDialog', [
            'showBack'      => true,
            'model'         => $model,
            'messageDialog' => $messageDialog
        ]);

        return [
            'html'      => $html,
            'requestId' => $messageDialog->request_id,
        ];
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
            return $this->renderPartial('dialogHistory', [
                'messageDialog' => MessageDialog::findById($model->message_dialog_id)
            ]);
        }

        return false;
    }
}