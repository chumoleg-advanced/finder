<?php

namespace app\modules\dashboard\components;

use common\models\category\Category;
use common\models\company\Company;
use Yii;
use yii\helpers\Url;

class MenuItems
{
    public static function getItems()
    {
        return [
            [
                'label' => '<i class="glyphicon glyphicon-plus"></i> Создать заявку',
                'items' => MenuItems::getCreateRequest()
            ],
            [
                'label' => 'Мои заявки',
                'url'   => Url::toRoute('request/index')
            ],
            [
                'label'   => 'Заявки от клиентов',
                'url'     => Url::toRoute('request-company/free'),
                'visible' => !empty(Company::getListByUser())
            ],
            [
                'label' => 'Заявки в работе',
                'items' => MenuItems::getCompanyRequests()
            ],
            [
                'label' => 'Мои компании',
                'items' => MenuItems::getCompanyManage()
            ],
            [
                'label' => '<i class="glyphicon glyphicon-bell"></i>',
                'url'   => Url::toRoute('message/index')
            ],
            [
                'label' => '<i class="glyphicon glyphicon-user"></i> '
                    . Yii::$app->user->identity->email,
                'items' => [
                    [
                        'label' => 'Профиль',
                        'url'   => Url::toRoute('profile/index')
                    ],
                    [
                        'label' => 'Настройки',
                        'url'   => Url::toRoute('setting/index')
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

    public static function getCreateRequest()
    {
        $createRequestItems = [];
        foreach (Category::getList() as $categoryObj) {
            $rubricItems = [];
            foreach ($categoryObj->rubrics as $rubric) {
                $rubricItems[] = [
                    'label' => $rubric->name,
                    'url'   => Url::toRoute(['request/create', 'id' => $rubric->id]),
                ];
            }

            $createRequestItems[] = [
                'label' => $categoryObj->name,
                'items' => $rubricItems
            ];
        }

        return $createRequestItems;
    }

    public static function getCompanyRequests()
    {
        $companyItems = [];

        $companies = Company::getListByUser();
        foreach ($companies as $id => $name) {
            $companyItems[] = [
                'label' => $name,
                'url'   => Url::toRoute([
                    'request-company/index',
                    'RequestSearch[performer_company_id]' => $id
                ])
            ];
        }

        return $companyItems;
    }

    public static function getCompanyManage()
    {
        $companyItems = [];

        $companies = Company::getListByUser();
        foreach ($companies as $id => $name) {
            $companyItems[] = [
                'label' => $name,
                'url'   => Url::toRoute(['company/view', 'id' => $id])
            ];
        }

        $companyItems[] = [
            'label' => '<i class="glyphicon glyphicon-plus"></i> Создать организацию',
            'url'   => Url::toRoute('company/create')
        ];

        return $companyItems;
    }
}