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
                'status' => Request::STATUS_OFFER_SENT
            ],
            'reject' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_REJECTED
            ]
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
