<?php

namespace frontend\modules\ajax\controllers;

use common\components\Status;
use common\models\message\Message;
use common\models\message\MessageDialog;
use common\models\notification\Notification;
use common\models\requestOffer\MainRequestOffer;
use common\models\requestOffer\RequestOffer;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use \yii\web\Response;

class MessageController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $search = Yii::$app->request->post('search');

        $dialogList = MessageDialog::getDialogList();
        $notificationList = Notification::getNotificationList();

        return $this->renderPartial('index', $this->_addCountersToArray([
            'dialogList'       => $dialogList,
            'notificationList' => $notificationList,
            'search'           => $search
        ]));
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function _addCountersToArray($array = [])
    {
        $countNewMessages = Message::getCountNewMessages();
        $countNewNotifications = Notification::getCountNewNotifications();

        $data = [
            'countAllNew'           => $countNewMessages + $countNewNotifications,
            'countNewMessages'      => $countNewMessages,
            'countNewNotifications' => $countNewNotifications,
        ];

        return ArrayHelper::merge($array, $data);
    }

    public function actionGetDialogContent()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $search = Yii::$app->request->post('search');

        $dialogList = MessageDialog::getDialogList();
        return $this->renderPartial('_dialogList', ['data' => $dialogList, 'search' => $search]);
    }

    public function actionGetNotificationContent()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $notificationList = Notification::getNotificationList();

        return $this->renderPartial('_notificationList', ['data' => $notificationList]);
    }

    public function actionUpdateCounters()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->_addCountersToArray();
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

        return $this->_addCountersToArray([
            'html'        => $html,
            'companyName' => $requestOffer->company->actual_name
        ]);
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

        return $this->_addCountersToArray([
            'html'               => $html,
            'requestId'          => $messageDialog->request_id,
            'requestDescription' => $messageDialog->request->description,
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
            $messageDialog = MessageDialog::findById($model->message_dialog_id);
            if ($messageDialog->status != Status::STATUS_ACTIVE) {
                $messageDialog->updateStatus(Status::STATUS_ACTIVE);
            }

            return $this->renderPartial('dialogHistory', [
                'messageDialog' => MessageDialog::findById($model->message_dialog_id)
            ]);
        }

        return false;
    }

    public function actionReadNotification()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)Yii::$app->request->post('id');
        if (empty($id)) {
            return false;
        }

        $model = Notification::findById($id);
        $model->status = Notification::STATUS_READ;
        $model->save(false);

        return ['location' => $model->getLocation()];
    }
}