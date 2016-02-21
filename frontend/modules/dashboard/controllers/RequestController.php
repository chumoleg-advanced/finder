<?php

namespace frontend\modules\dashboard\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use frontend\forms\request\BaseForm;
use common\components\SaveRequest;
use common\models\request\Request;
use common\models\requestOffer\RequestOffer;
use common\models\request\RequestSearch;
use common\models\rubric\Rubric;

class RequestController extends Controller
{
    public function actions()
    {
        return [
            'close' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_CLOSED
            ],
            'reset' => [
                'class'  => 'common\components\actions\ChangeStatusAction',
                'status' => Request::STATUS_NEW
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RequestSearch();
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

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $bestOffer = null;
        $otherOffersDataProvider = null;
        if ($model->status != Request::STATUS_NEW) {
            $bestOffer = RequestOffer::getBestOfferByRequest($id);
            if (!empty($bestOffer)) {
                $otherOffersDataProvider = RequestOffer::getOtherOffersByRequest($id, $bestOffer->id);
            }
        }

        return $this->render('view', [
            'model'                   => $model,
            'bestOffer'               => $bestOffer,
            'otherOffersDataProvider' => $otherOffersDataProvider
        ]);
    }

    /**
     * @param $id
     *
     * @return Request|null
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        $model = Request::findById($id);
        if (empty($model) || $model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('Заявка не найдена');
        }

        return $model;
    }

    public function actionResult()
    {
        return $this->render('result');
    }

    public function actionCreate($id)
    {
        $rubric = Rubric::findById($id);
        $formModel = $rubric->geFormModelClassName();

        /** @var BaseForm $model */
        $model = new $formModel();
        if ($url = SaveRequest::save($model, $rubric->id)) {
            return $this->redirect($url);
        }

        return $this->render('//search/form', [
            'hideBackLink' => true,
            'rubric'       => $rubric,
            'formView'     => $rubric->getViewName(),
            'formModel'    => $model
        ]);
    }

    protected function getModel()
    {
        return Request::className();
    }
}