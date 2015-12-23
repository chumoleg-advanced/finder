<?php

namespace app\modules\ajax\controllers;

use Yii;
use yii\web\Controller;
use common\forms\LoginForm;

class AuthController extends Controller
{
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->validate()) {
            $model->login();
            return true;
        } else {
            return false;
        }
    }
}
