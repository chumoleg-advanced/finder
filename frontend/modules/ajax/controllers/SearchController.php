<?php

namespace frontend\modules\ajax\controllers;

use Yii;
use common\models\autoPart\AutoPart;
use frontend\searchForms\QueryArrayForm;
use kartik\widgets\ActiveForm;
use common\components\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\Controller;
use common\models\rubric\Rubric;
use \yii\helpers\Json;
use frontend\searchForms\BaseForm;
use \yii\web\Response;

class SearchController extends Controller
{
    public function actionValidate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return [];
        }

        $postData = Yii::$app->request->post();
        $rubric = Rubric::findById($id);
        if (empty($rubric) || empty($postData)) {
            return [];
        }

        $formModel = $rubric->geFormModelClassName();

        /** @var BaseForm $model */
        $model = new $formModel();
        if ($model->load($postData)) {
            $errors = ActiveForm::validate($model);

            $scenario = null;
            if (StringHelper::basename($model->className()) == 'AutoPartForm') {
                $scenario = 'parts';
            }

            $modelRows = Model::createMultiple(QueryArrayForm::classname(), [], $scenario);
            Model::loadMultiple($modelRows, Yii::$app->request->post());

            $errors += ActiveForm::validateMultiple($modelRows);

            return $errors;
        }

        return [];
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
        $data = AutoPart::findAllByName($q);

        $out = [];
        foreach ($data as $item) {
            $out[] = ['value' => $item->name];
        }

        return $out;
    }
}