<?php

namespace console\controllers;

use common\components\Role;
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
            $userList = User::getUsersByRole(Role::ADMIN);

        } else {
            $userObj = User::findById($forUser);
            $userNotifications = NotificationSetting::getTypeListByUser($userObj->id);
            if (in_array($type, $userNotifications)) {
                $userList = [$userObj];
            }
        }

        if (empty($userList)) {
            return;
        }

        $subject = Notification::$subjectList[$type];
        $subject = str_replace('{modelId}', $modelId, $subject);

        foreach ($userList as $userObj) {
            if ($type != Notification::TYPE_NEW_MESSAGE) {
                Notification::create($userObj->id, $type, $subject);
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