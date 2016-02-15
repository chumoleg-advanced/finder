<?php

namespace frontend\modules\dashboard\controllers;

use common\components\Model;
use common\models\request\RequestView;
use frontend\modules\dashboard\forms\RequestOfferForm;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\models\requestOffer\MainRequestOffer;
use common\models\requestOffer\MainRequestOfferSearch;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

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
        Url::remember('', 'requestOfferList');
    }

    public function actionOffer()
    {
        $id = Yii::$app->request->get('id');
        if (!empty($id)) {
            $model = $this->_loadModel($id);
        } else {
            $requestId = Yii::$app->request->get('requestId');
            $model = $this->_loadModelByRequest($requestId);
        }

        $postData = Yii::$app->request->post();
        if (!empty($postData['RequestOfferForm'])) {
            /** @var RequestOfferForm[] $modelRows */
            $modelRows = Model::createMultiple(RequestOfferForm::classname(), [], null, true);
            Model::loadMultiple($modelRows, Yii::$app->request->post());
            ActiveForm::validateMultiple($modelRows);

            foreach ($modelRows as $k => $requestOffer) {
                if (!empty($requestOffer->id)) {
                    continue;
                }

                $requestOffer->mainRequestOffer = $model;
                $requestOffer->imageData = UploadedFile::getInstances($requestOffer, '[' . $k . ']imageData');
                $requestOffer->create();
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
    private function _loadModel($id)
    {
        $model = MainRequestOffer::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Заявка не найдена');
        }

        return $model;
    }

    /**
     * @param $requestId
     *
     * @return MainRequestOffer|null
     * @throws NotFoundHttpException
     */
    private function _loadModelByRequest($requestId)
    {
        $model = MainRequestOffer::find()->andWhere([
            'request_id' => $requestId,
            'user_id'    => Yii::$app->user->id
        ])->one();

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