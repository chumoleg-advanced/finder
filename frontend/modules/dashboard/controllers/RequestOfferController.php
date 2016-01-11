<?php

namespace frontend\modules\dashboard\controllers;

use common\models\request\RequestView;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\models\request\RequestOffer;
use common\models\request\RequestOfferSearch;

class RequestOfferController extends Controller
{
    public function actions()
    {
        return [
            'close' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => RequestOffer::STATUS_CLOSED
            ],
            'reset'  => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => RequestOffer::STATUS_NEW
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RequestOfferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->_rememberUrl();

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function _rememberUrl()
    {
        Url::remember('', 'requestList');
    }

    public function actionOffer($id)
    {
        $formModel = $this->loadModel($id);
        if ($formModel->status == RequestOffer::STATUS_NEW) {
            $checkView = RequestView::findByUserIp($formModel->request_id);
            if (!$checkView) {
                $formModel->request->updateCounters(['count_view' => 1]);
            }

            $formModel->scenario = 'update';
            if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
                $formModel->status = RequestOffer::STATUS_ACTIVE;
                $formModel->save();

                return $this->redirect(['index']);
            }
        }

        return $this->render('form', [
            'formModel' => $formModel
        ]);
    }

    /**
     * @param $id
     *
     * @return RequestOffer|null
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        $model = RequestOffer::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Заявка не найдена');
        }

        return $model;
    }

    protected function getModel()
    {
        return RequestOffer::className();
    }
}