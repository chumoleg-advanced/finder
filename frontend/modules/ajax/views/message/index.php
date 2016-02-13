<?php

echo \yii\bootstrap\Tabs::widget([
    'items' => [
        [
            'label'   => 'Переписка',
            'content' => $this->render('_dialogList', ['data' => $dialogList, 'search' => $search]),
            'active'  => true
        ],
        [
            'label'         => 'Уведомления',
            'content' => $this->render('_notificationList', ['data' => $notificationList]),
            'headerOptions' => [],
            'options'       => ['id' => 'myveryownID'],
        ]
    ],
]);
