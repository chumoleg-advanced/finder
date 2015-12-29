<?php

namespace app\modules\ajax\controllers;

use common\components\Status;
use common\models\request\Request;
use common\models\request\RequestOffer;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class RequestController extends Controller
{
    public function actionAcceptOffer()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $requestId = (int)Yii::$app->request->post('requestId');
        $offerId = (int)Yii::$app->request->post('requestOfferId');
        if (empty($requestId) || empty($offerId)) {
            return ['status' => false, 'msg' => 'Неопознанная ошибка!'];
        }

        $request = Request::findById($requestId);
        $offer = RequestOffer::findById($offerId);
        if (empty($request) || empty($offer) || $offer->request_id != $request->id) {
            return ['status' => false, 'msg' => 'Неопознанная ошибка!'];
        }

        $request->performer_company_id = $offer->company_id;
        $request->request_offer_id = $offer->id;
        if (!$request->updateStatus(Request::STATUS_IN_WORK)) {
            return ['status' => false, 'msg' => 'Ошибка при изменении статуса!'];
        }

        RequestOffer::updateAll(['status' => Status::STATUS_DISABLED], 'request_id = ' . $request->id);

        return ['status' => true, 'url' => Url::to('/dashboard/request/index')];
    }
}
