<?php

namespace backend\controllers;

use Yii;
use common\components\CrudController;
use common\models\user\User;
use common\models\user\UserSearch;

class UserController extends CrudController
{
    protected function getModel()
    {
        return User::className();
    }

    protected function getSearchModel()
    {
        return UserSearch::className();
    }
}
