<?php

namespace common\components;

use common\models\user\User;

class Role
{
    const ADMIN = 'ADMIN';
    const MODERATOR = 'MODERATOR';
    const USER = 'USER';

    /**
     * @param User   $user
     * @param string $role
     */
    public static function assignRoleForUser(User $user, $role = self::USER)
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($role);
        if ($role) {
            $authManager->assign($role, $user->getId());
        }
    }
}
