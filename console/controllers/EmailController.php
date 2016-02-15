<?php

namespace console\controllers;

use common\components\Role;
use common\models\company\Company;
use Yii;
use yii\console\Controller;
use common\models\notification\NotificationSetting;
use common\models\notification\Notification;
use common\models\user\User;

class EmailController extends Controller
{
    public function actionSend($type, $modelId, $forUser = null)
    {
        $type = (int)$type;
        $modelId = (int)$modelId;
        if (empty($type) || empty($modelId)) {
            return;
        }

        $typeList = array_keys(Notification::$subjectList);
        if (!in_array($type, $typeList)) {
            return;
        }

        if (empty($forUser)) {
            $userIds = Yii::$app->authManager->getUserIdsByRole(Role::ADMIN);
            $userList = User::find()->whereId($userIds)->all();

        } else {
            $userObj = User::findById($forUser);
            $userNotifications = NotificationSetting::getTypeListByUser($userObj->id);
            if (in_array($type, $userNotifications) || $type == Notification::TYPE_ACCEPT_COMPANY) {
                $userList = [$userObj];
            }
        }

        if (empty($userList)) {
            return;
        }

        $subject = Notification::$subjectList[$type];
        $subject = str_replace('{modelId}', $modelId, $subject);
        if ($type == Notification::TYPE_ACCEPT_COMPANY) {
            $company = Company::findById($modelId);
            $subject = str_replace('{modelName}', $company->actual_name, $subject);
        }

        foreach ($userList as $userObj) {
            if (!empty($forUser) && $type != Notification::TYPE_NEW_MESSAGE) {
                Notification::create($userObj->id, $type, $subject, $modelId);
            }

            Yii::$app->mailer->compose()
                ->setFrom('no-reply@finder.ru')
                ->setTo($userObj->email)
                ->setSubject($subject)
                ->setTextBody($subject)
//                ->setHtmlBody('<b>HTML content</b>')
                ->send();
        }
    }
}