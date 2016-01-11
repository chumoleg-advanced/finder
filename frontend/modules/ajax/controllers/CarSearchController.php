<?php

namespace frontend\modules\ajax\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\car\CarBody;
use common\models\car\CarModel;
use common\models\car\CarEngine;
use kartik\helpers\Html;

class CarSearchController extends Controller
{
    public function actionCarModel()
    {
        $data = CarModel::getListByFirm($this->_getId());
        $this->_renderSelect($data);
    }

    /**
     * @return mixed
     */
    private function _getId()
    {
        return Yii::$app->request->getBodyParam('id');
    }

    /**
     * @param $data
     */
    private function _renderSelect($data)
    {
        $attributes = Yii::$app->request->getBodyParam('attributes');
        echo Html::dropDownList(ArrayHelper::getValue($attributes, 'name'), null, $data, [
            'id'     => ArrayHelper::getValue($attributes, 'id'),
            'name'   => ArrayHelper::getValue($attributes, 'name'),
            'prompt' => ArrayHelper::getValue($attributes, 'prompt')
        ]);
    }

    public function actionCarBody()
    {
        $data = CarBody::getListByModel($this->_getId());
        $this->_renderSelect($data);
    }

    public function actionCarEngine()
    {
        $data = CarEngine::getListByBody($this->_getId());
        $this->_renderSelect($data);
    }
}
