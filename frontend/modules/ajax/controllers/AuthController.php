<?php

namespace app\modules\ajax\controllers;

use app\forms\SignUpForm;
use Yii;
use yii\web\Controller;
use common\forms\LoginForm;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->validate()) {
            return $model->login();
        }

        return false;
    }

    public function actionSignup()
    {
        $model = new SignUpForm();
        $model->load(Yii::$app->request->post());
        if ($model->validate()) {
            return $model->signup();
        }

        return false;
    }
}
