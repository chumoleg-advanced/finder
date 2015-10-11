<?php

use yii\rbac\Item;
use common\components\Role;

return [
    Item::TYPE_PERMISSION => [
        'accessToBackend'         => 'Доступ к Административной части',
        'accessToPersonalCabinet' => 'Доступ к личному кабинету пользователя',
        'accessManage'            => 'Управление правилами доступа',
        'roleManage'              => 'Управление правилами доступа для роли',
        'userManage'              => 'Управление пользователями',
        'userRoleManage'          => 'Управление ролями пользователей',
    ],
    Item::TYPE_ROLE       => [
        Role::ADMIN     => 'Administrator',
        Role::MODERATOR => 'Moderator',
        Role::USER      => 'Registered User',
    ],
];