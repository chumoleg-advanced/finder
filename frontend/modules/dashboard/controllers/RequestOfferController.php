<?php

namespace frontend\modules\dashboard\controllers;

use common\components\Model;
use common\models\request\RequestView;
use common\models\requestOffer\RequestOffer;
use frontend\modules\dashboard\forms\RequestOfferForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\models\requestOffer\MainRequestOffer;
use common\models\requestOffer\MainRequestOfferSearch;
use yii\web\UploadedFile;

class RequestOfferController extends Controller
{
    public function actions()
    {
        return [
            'close' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => MainRequestOffer::STATUS_CLOSED
            ],
            'reset' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => MainRequestOffer::STATUS_NEW
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new MainRequestOfferSearch();
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
        $model = $this->loadModel($id);

        $postData = Yii::$app->request->post();
        if (!empty($postData)) {
            /** @var RequestOfferForm[] $modelRows */
            $oldIDs = ArrayHelper::map($model->requestOffers, 'id', 'id');
            $modelRows = Model::createMultiple(RequestOfferForm::classname(), $model->requestOffers);
            Model::loadMultiple($modelRows, Yii::$app->request->post());

            $deletedIds = array_diff($oldIDs, array_filter(ArrayHelper::map($modelRows, 'id', 'id')));
            if (!empty($deletedIds)) {
                RequestOffer::deleteAll(['id' => $deletedIds]);
            }

            foreach ($modelRows as $k => $requestOffer) {
                $requestOffer->mainRequestOffer = $model;
                $requestOffer->imageData = UploadedFile::getInstances(
                    $requestOffer, '[' . $k . ']imageData');

                if (!empty($requestOffer->id)) {
                    $requestOffer->update();
                } else {
                    $requestOffer->create();
                }
            }

            $model->status = MainRequestOffer::STATUS_ACTIVE;
            $model->save();

            return $this->redirect(['index']);
        }

        $checkView = RequestView::findByUserIp($model->request_id);
        if (!$checkView) {
            $model->request->updateCounters(['count_view' => 1]);
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     *
     * @return MainRequestOffer|null
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        $model = MainRequestOffer::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Заявка не найдена');
        }

        return $model;
    }

    protected function getModel()
    {
        return MainRequestOffer::className();
    }
}