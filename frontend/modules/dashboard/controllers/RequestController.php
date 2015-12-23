<?php

namespace app\modules\dashboard\controllers;

use app\searchForms\BaseForm;
use common\components\SaveRequest;
use common\models\rubric\Rubric;
use Yii;
use app\modules\dashboard\components\Controller;

class RequestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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