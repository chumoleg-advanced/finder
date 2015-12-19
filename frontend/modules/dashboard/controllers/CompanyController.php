<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\components\Controller;
use app\modules\dashboard\forms\CompanyForm;

class CompanyController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new CompanyForm();
        if ($model->load(Yii::$app->request->post()) && $model->createCompany()) {
            return $this->redirect('index');
        }

        return $this->render('form', ['model' => $model]);
    }
}