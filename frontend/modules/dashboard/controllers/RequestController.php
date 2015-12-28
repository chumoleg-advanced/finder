<?php

namespace app\modules\dashboard\controllers;

use app\searchForms\BaseForm;
use common\components\SaveRequest;
use common\models\category\Category;
use common\models\company\Company;
use common\models\request\Request;
use common\models\request\RequestSearch;
use common\models\rubric\Rubric;
use Yii;
use app\modules\dashboard\components\Controller;

class RequestController extends Controller
{
    public function actionIndexUser()
    {
        $categories = Category::getList(true);
        $categories[0] = 'Все категории';
        ksort($categories);

        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'user');

        return $this->render('indexUser', [
            'categories'   => $categories,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexCompany()
    {
        $companies = Company::getListByUser(Yii::$app->user->id);
        $companies[0] = 'Все компании';
        ksort($companies);

        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'company');

        return $this->render('indexCompany', [
            'companies'    => $companies,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Request::findById($id)
        ]);
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
}