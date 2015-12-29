<?php

namespace app\modules\dashboard\controllers;

use common\models\company\Company;
use common\models\request\Request;
use common\models\request\RequestOffer;
use common\models\request\RequestSearch;
use Yii;
use app\modules\dashboard\components\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RequestCompanyController extends Controller
{
    public function actionIndex()
    {
        $companies = Company::getListByUser();
        $companies[0] = 'Все компании';
        ksort($companies);

        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'company');

        $this->_rememberUrl();

        return $this->render('index', [
            'companies'    => $companies,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function _rememberUrl()
    {
        Url::remember('', 'requestList');
    }

    public function actionFree()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'free');

        $this->_rememberUrl();

        return $this->render('free', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->_loadModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionOffer($id)
    {
        $model = $this->_loadModel($id);

        $formModel = new RequestOffer();
        $formModel->request_id = $id;
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('form', [
            'model'     => $model,
            'formModel' => $formModel
        ]);
    }

    /**
     * @param $id
     *
     * @return Request|null
     * @throws NotFoundHttpException
     */
    private function _loadModel($id)
    {
        $model = Request::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Заявка не найдена');
        }

        return $model;
    }
}