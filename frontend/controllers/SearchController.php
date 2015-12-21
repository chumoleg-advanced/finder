<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\components\Controller;
use common\models\category\Category;
use common\models\rubric\Rubric;
use app\searchForms\BaseForm;

class SearchController extends Controller
{
    public function actionResult()
    {
        return $this->render('result');
    }

    public function actionForm($id)
    {
        $rubric = Rubric::findById($id);
        $formModel = $rubric->geFormModelClassName();

        /** @var BaseForm $model */
        $model = new $formModel();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->submitForm()) {
                return $this->redirect(Url::to(['result']));
            }
        }

        return $this->render('form', [
            'rubric'    => $rubric,
            'formView'  => $rubric->getViewName(),
            'formModel' => $model
        ]);
    }

    public function actionSearch()
    {
        $categories = Category::getList();
        return $this->render('category', ['categories' => $categories]);
    }

    public function actionCategory($id)
    {
        $rubrics = Rubric::findAllByCategory($id);
        return $this->render('rubric', ['rubrics' => $rubrics]);
    }
}