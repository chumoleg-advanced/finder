<?php

use common\components\Role;

return [
    Role::ADMIN => [
        'accessToBackend',
        'accessManage',
        'roleManage',
        'userManage',
        'userRoleManage',
        'accessToPersonalCabinet',
    ]
];