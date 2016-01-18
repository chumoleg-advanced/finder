<?php

namespace frontend\modules\ajax\controllers;

use Yii;
use kartik\widgets\ActiveForm;
use common\components\Model;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\dashboard\forms\RequestOfferForm;

class RequestOfferController extends Controller
{
    public function actionValidate($scenario)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return [];
        }

        $postData = Yii::$app->request->post();
        if (empty($postData)) {
            return [];
        }

        $modelRows = Model::createMultiple(RequestOfferForm::classname(), [], $scenario);
        Model::loadMultiple($modelRows, Yii::$app->request->post());

        return ActiveForm::validateMultiple($modelRows);
    }
}