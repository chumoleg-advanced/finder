<?php

namespace app\modules\dashboard\controllers;

use app\searchForms\BaseForm;
use common\components\SaveRequest;
use common\models\category\Category;
use common\models\request\Request;
use common\models\request\RequestOffer;
use common\models\request\RequestSearch;
use common\models\rubric\Rubric;
use Yii;
use app\modules\dashboard\components\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

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
                'status' => Request::STATUS_IN_WORK
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'user');

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
        $otherOffers = [];
        if ($model->status != Request::STATUS_NEW) {
            list($bestOffer, $otherOffers) = RequestOffer::findListByRequest($id);
        }

        return $this->render('view', [
            'model'       => $model,
            'bestOffer'   => $bestOffer,
            'otherOffers' => $otherOffers
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
        if (empty($model)) {
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