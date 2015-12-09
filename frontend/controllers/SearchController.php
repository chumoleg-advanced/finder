<?php

namespace frontend\controllers;

use common\models\autoPart\AutoPart;
use frontend\searchForms\QueryArrayForm;
use kartik\widgets\ActiveForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\category\Category;
use common\models\rubric\Rubric;
use \yii\helpers\Json;
use frontend\searchForms\BaseForm;
use \yii\web\Response;

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
        Yii::$app->response->format = Response::FORMAT_JSON;

        $url
            = 'https://geocode-maps.yandex.ru/1.x/?format=json&results=10&lang=ru_RU&ll=82.9204,55.0302&spn=0.7,0.7&rspn=1&geocode='
            . $q;
        $data = Yii::$app->curl->get($url);
        $data = Json::decode($data);
        $finalData = ArrayHelper::getValue($data, 'response.GeoObjectCollection.featureMember');

        $out = [];
        foreach ($finalData as $item) {
            $text = ArrayHelper::getValue($item, 'GeoObject.metaDataProperty.GeocoderMetaData.text');
            $pointVal = ArrayHelper::getValue($item, 'GeoObject.Point.pos');
            if (!empty($pointVal)) {
                $pointVal = explode(' ', $pointVal);
                sort($pointVal);
            }

            if (!empty($text)) {
                $out[] = ['text' => $text, 'point' => $pointVal];
            }
        }

        return $out;
    }

    public function actionPartsList($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = AutoPart::find()->andWhere(['LIKE', 'name', $q])->orderBy('LENGTH(name)')->limit(10)->all();

        $out = [];
        foreach ($data as $item) {
            $out[] = ['value' => $item->name];
        }

        return $out;
    }
}