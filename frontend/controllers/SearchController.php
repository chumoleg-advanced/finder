<?php

namespace app\controllers;

use common\components\SaveRequest;
use Yii;
use app\components\Controller;
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
        if ($url = SaveRequest::save($model, $rubric->id)) {
            return $this->redirect($url);
        }

        return $this->render('form', [
            'rubric'    => $rubric,
            'formView'  => $rubric->getViewName(),
            'formModel' => $model
        ]);
    }

    public function actionSearch()
    {
        return $this->render('category');
    }

    public function actionCategory($id)
    {
        $rubrics = Rubric::findAllByCategory($id);
        return $this->render('rubric', ['rubrics' => $rubrics]);
    }
}