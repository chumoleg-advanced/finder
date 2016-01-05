<?php

namespace backend\controllers;

use Yii;
use common\components\CrudController;
use common\models\request\Request;
use common\models\request\RequestSearch;

class RequestController extends CrudController
{
    public function actions()
    {
        return [
            'accept' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_IN_WORK
            ],
            'reject' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_REJECTED
            ],
            'reset'  => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_NEW
            ],
        ];
    }

    protected function getModel()
    {
        return Request::className();
    }

    protected function getSearchModel()
    {
        return RequestSearch::className();
    }
}
