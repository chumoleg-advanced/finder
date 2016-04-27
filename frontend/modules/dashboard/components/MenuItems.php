<?php

namespace frontend\modules\dashboard\components;

use common\models\company\Company;
use common\models\message\Message;
use common\models\notification\Notification;
use Yii;
use yii\helpers\Url;

class MenuItems
{
    public static function getItems()
    {
        $countAllNewMessages = Message::getCountNewMessages() + Notification::getCountNewNotifications();
        $messageBadge = $countAllNewMessages > 0 ? $countAllNewMessages : '';
        $messageBadge = ' <span class="badge messageBadgeMenu">' . $messageBadge . '</span>';

        return [
//            [
//                'label' => '<i class="glyphicon glyphicon-plus"></i> Создать заявку',
//                'items' => MenuItems::getCreateRequest()
//            ],
            [
                'label' => 'Мои заявки',
                'url'   => Url::toRoute('request/index')
            ],
            [
                'label'   => 'Заявки от клиентов',
                'url'     => Url::toRoute('request-offer/index'),
                'visible' => !empty(Company::getListByUser())
            ],
            [
                'label' => 'Мои компании',
                'items' => MenuItems::getCompanyManage(),
            ],
            [
                'label'   => '<i class="glyphicon glyphicon-bell"></i>' . $messageBadge,
                'url'     => '#',
                'options' => ['class' => 'messageButton']
            ],
            [
                'label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::$app->user->identity->email,
                'items' => [
                    [
                        'label' => 'Настройки',
                        'url'   => Url::toRoute('profile/index')
                    ],
                    [
                        'label'       => 'Выход',
                        'url'         => Url::to('/auth/logout'),
                        'linkOptions' => ['data-method' => 'post']
                    ],
                ]
            ]
        ];
    }

    public static function getCompanyManage()
    {
        $companyItems = [];

        $companies = Company::getListByUser();
        foreach ($companies as $id => $name) {
            $companyItems[] = [
                'label' => $name,
                'url'   => Url::toRoute(['company/update', 'id' => $id])
            ];
        }

        $companyItems[] = [
            'label' => '<i class="glyphicon glyphicon-plus"></i> Создать компанию',
            'url'   => Url::toRoute('company-create/index')
        ];

        return $companyItems;
    }
}