<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\category\Category;
use common\models\rubric\Rubric;
use \yii\helpers\Json;
use frontend\searchForms\BaseForm;

class SearchController extends Controller
{
    public function actionResult()
    {
        return $this->render('result');
    }

    public function actionForm($id)
    {
        $rubric = Rubric::find()->whereId($id)->one();

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
        $categories = Category::find()->all();
        return $this->render('category', ['categories' => $categories]);
    }

    public function actionCategory($id)
    {
        $rubrics = Rubric::find()->whereCategoryId($id)->all();
        return $this->render('rubric', ['rubrics' => $rubrics]);
    }

    public function actionAddressList($q = null)
    {
        $url = 'https://geocode-maps.yandex.ru/1.x/?format=json&results=10&lang=ru_RU&geocode=' . $q;
        $data = Yii::$app->curl->get($url);
        $data = Json::decode($data);
        $finalData = ArrayHelper::getValue($data, 'response.GeoObjectCollection.featureMember');

        $out = [];
        foreach ($finalData as $item) {
            $text = ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.text');
            if (!empty($text)){
                $out[] = ['value' => $text];
            }
        }

        echo Json::encode($out);
    }
}