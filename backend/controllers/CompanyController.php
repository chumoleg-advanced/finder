<?php

namespace backend\controllers;

use Yii;
use common\components\CrudController;
use common\models\company\Company;
use common\models\company\CompanySearch;

class CompanyController extends CrudController
{
    public function actions()
    {
        return [
            'reset'  => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Company::STATUS_ON_MODERATE
            ],
            'accept' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Company::STATUS_ACTIVE
            ],
            'reject' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Company::STATUS_BLOCKED
            ]
        ];
    }

    protected function getModel()
    {
        return Company::className();
    }

    protected function getSearchModel()
    {
        return CompanySearch::className();
    }
}
