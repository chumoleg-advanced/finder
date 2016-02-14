<?php

$dialogBadge = '';
if ($countNewMessages > 0) {
    $dialogBadge = ' <span class="badge messagesBadge">' . $countNewMessages . '</span>';
}

$notificationBadge = '';
if ($countNewNotifications > 0) {
    $notificationBadge = ' <span class="badge notificationsBadge">' . $countNewNotifications . '</span>';
}

echo \yii\bootstrap\Tabs::widget([
    'id'    => 'personalMessagesAndNotification',
    'items' => [
        [
            'label'   => 'Переписка' . $dialogBadge,
            'encode'  => false,
            'content' => $this->render('_dialogList', ['data' => $dialogList, 'search' => $search]),
            'active'  => true
        ],
        [
            'label'   => 'Уведомления' . $notificationBadge,
            'encode'  => false,
            'content' => $this->render('_notificationList', ['data' => $notificationList]),
        ]
    ],
]);