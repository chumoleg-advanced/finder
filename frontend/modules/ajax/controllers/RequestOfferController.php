<?php

namespace frontend\modules\ajax\controllers;

use common\models\requestOffer\RequestOffer;
use Yii;
use kartik\widgets\ActiveForm;
use common\components\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use frontend\modules\dashboard\forms\RequestOfferForm;

class RequestOfferController extends Controller
{
    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return [];
        }

        $postData = Yii::$app->request->post();
        if (empty($postData['RequestOfferForm'])) {
            return [];
        }

        $modelRows = Model::createMultiple(RequestOfferForm::classname(), [], null, true);
        Model::loadMultiple($modelRows, $postData);

        return ActiveForm::validateMultiple($modelRows);
    }

    public function actionCopyInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $requestOfferId = (int)Yii::$app->request->post('id');

        $requestOffer = RequestOffer::findById($requestOfferId);
        $attributes = ArrayHelper::map($requestOffer->requestOfferAttributes, 'attribute_name', 'value');

        return [
            'description'     => $requestOffer->description,
            'comment'         => $requestOffer->comment,
            'price'           => $requestOffer->price,
            'companyId'       => $requestOffer->company_id,
            'availability'    => ArrayHelper::getValue($attributes, 'availability'),
            'deliveryDayFrom' => ArrayHelper::getValue($attributes, 'deliveryDayFrom'),
            'deliveryDayTo'   => ArrayHelper::getValue($attributes, 'deliveryDayTo'),
            'partsCondition'  => ArrayHelper::getValue($attributes, 'partsCondition'),
            'partsOriginal'   => ArrayHelper::getValue($attributes, 'partsOriginal'),
            'discType'        => ArrayHelper::getValue($attributes, 'discType'),
            'tireType'        => ArrayHelper::getValue($attributes, 'tireType'),
            'tireTypeWinter'  => ArrayHelper::getValue($attributes, 'tireTypeWinter'),
        ];
    }
}