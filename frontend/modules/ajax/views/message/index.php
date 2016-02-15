<?php

$dialogBadge = $countNewMessages > 0 ? $countNewMessages : '';
$notificationBadge = $countNewNotifications > 0 ? $countNewNotifications : '';

echo \yii\bootstrap\Tabs::widget([
    'id'    => 'personalMessagesAndNotification',
    'items' => [
        [
            'label'   => 'Переписка' . ' <span class="badge messagesBadge">' . $dialogBadge . '</span>',
            'encode'  => false,
            'content' => $this->render('_dialogList', ['data' => $dialogList, 'search' => $search]),
            'active'  => true,
            'options' => ['id' => 'messageDialogTab'],
        ],
        [
            'label'   => 'Уведомления' . ' <span class="badge notificationsBadge">' . $notificationBadge . '</span>',
            'encode'  => false,
            'content' => $this->render('_notificationList', ['data' => $notificationList]),
            'options' => ['id' => 'messageNotificationTab'],
        ]
    ],
]);