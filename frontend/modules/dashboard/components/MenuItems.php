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
                'label'   => '
                    <div class="svg">
                        <svg width="18" height="22" viewBox="0 0 18 22">
                          <path d="M9.000,22.000 C10.165,22.000 11.118,21.010 11.118,19.800 L6.882,19.800 C6.882,21.010 7.835,22.000 9.000,22.000 ZM15.882,15.400 L15.882,9.350 C15.882,5.940 13.659,3.190 10.588,2.420 L10.588,1.650 C10.588,0.770 9.847,-0.000 9.000,-0.000 C8.153,-0.000 7.412,0.770 7.412,1.650 L7.412,2.420 C4.341,3.190 2.118,5.940 2.118,9.350 L2.118,15.400 L-0.000,17.600 L-0.000,18.700 L18.000,18.700 L18.000,17.600 L15.882,15.400 Z"/>
                        </svg>
                    </div>
                ' . $messageBadge,
                'url'     => '#',
                'options' => ['class' => 'messageButton']
            ],
            [
                'label' => '
                    <div class="svg">
                        <svg width="21" height="21" viewBox="0 0 21 21">
                          <path d="M10.341,10.400 C13.185,10.400 15.511,8.060 15.511,5.200 C15.511,2.340 13.185,-0.000 10.341,-0.000 C7.497,-0.000 5.170,2.340 5.170,5.200 C5.170,8.060 7.497,10.400 10.341,10.400 ZM10.341,13.000 C6.851,13.000 -0.000,14.690 -0.000,18.200 L-0.000,20.800 L20.682,20.800 L20.682,18.200 C20.682,14.690 13.831,13.000 10.341,13.000 Z"/>
                        </svg>
                    </div>
                ' . Yii::$app->user->identity->email,
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