<?php

namespace frontend\modules\dashboard\controllers;

use common\models\user\User;
use frontend\modules\dashboard\forms\user\UserDataForm;
use Yii;
use yii\web\Controller;

class SettingController extends Controller
{
    public function actionIndex()
    {
        $userModel = User::findById(Yii::$app->user->id);

        $model = new UserDataForm();
        $model->userId = $userModel->id;
        $postData = Yii::$app->request->post('UserDataForm');
        if (!empty($postData)) {
            $model->attributes = $postData;
            if ($model->saveForm()){
                Yii::$app->getSession()->setFlash('success', 'Данные успешно обновлены!');
                return $this->refresh();
            }

        } else {
            $model->attributes = $userModel->attributes;
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}