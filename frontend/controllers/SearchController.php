<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\category\Category;
use common\models\rubric\Rubric;

class SearchController extends Controller
{
    public function actionResult()
    {
        return $this->render('result');
    }

    public function actionForm($id)
    {
        $rubric = Rubric::find()->whereId($id)->one();
        return $this->render('form', [
            'rubric'    => $rubric,
            'formView'  => $rubric->getViewName(),
            'formModel' => $rubric->geFormModel()
        ]);
    }

    public function actionSearch()
    {
        $categories = Category::find()->all();
        return $this->render('category', ['categories' => $categories]);
    }

    public function actionCategory($id)
    {
        $rubrics = Rubric::find()->whereCategoryId($id)->all();
        return $this->render('rubric', ['rubrics' => $rubrics]);
    }
}