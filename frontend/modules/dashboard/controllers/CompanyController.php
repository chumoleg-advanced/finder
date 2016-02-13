<?php

namespace frontend\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use kartik\form\ActiveForm;
use frontend\modules\dashboard\forms\company\ContactData;
use frontend\modules\dashboard\forms\company\MainData;
use frontend\modules\dashboard\forms\company\RubricData;
use common\components\Model;
use common\models\company\Company;
use common\models\company\CompanyContactData;

class CompanyController extends Controller
{
    public function actionUpdate($id)
    {
        $model = $this->_loadModel($id);

        $postData = Yii::$app->request->post();
        if (!empty($postData) && empty($this->_validateAllModels())) {
            $mainModel = new MainData();
            $rubricModel = new RubricData();
            $contactModel = new ContactData();

            $mainModel->companyId = $id;
            $mainModel->load($postData);
            $mainModel->validate();

            $rubricModel->load($postData);
            $rubricModel->validate();

            $contactModel->load($postData);
            $contactModel->contactDataValues = ArrayHelper::getValue($postData, 'CompanyContactData');

            if ($model->updateModel($mainModel, $rubricModel, $contactModel)) {
                Yii::$app->getSession()->setFlash('success', 'Данные успешно обновлены!');
                return $this->refresh();
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     *
     * @return Company
     * @throws NotFoundHttpException
     */
    private function _loadModel($id)
    {
        $model = Company::findById($id);
        if (empty($model)) {
            throw new NotFoundHttpException('Компания не найдена');
        }

        return $model;
    }

    /**
     * @return array
     */
    private function _validateAllModels()
    {
        $postData = Yii::$app->request->post();

        $mainModel = new MainData();
        $rubricModel = new RubricData();
        $contactModel = new ContactData();

        if ($mainModel->load($postData)
            && $rubricModel->load($postData)
            && $contactModel->load($postData)
        ) {
            $errors = ActiveForm::validate($mainModel);
            $errors += ActiveForm::validate($rubricModel);
            $errors += ActiveForm::validate($contactModel);
            $errors += $this->_checkCompanyContacts($postData, []);

            return $errors;
        }

        return [];
    }

    /**
     * @param $postData
     * @param $errors
     *
     * @return array
     */
    private function _checkCompanyContacts($postData, $errors)
    {
        if (isset($postData['CompanyContactData'])) {
            $modelRows = Model::createMultiple(CompanyContactData::classname());
            Model::loadMultiple($modelRows, $postData);
            $errors += ActiveForm::validateMultiple($modelRows);
        }

        return $errors;
    }

    public function actionValidate($step = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $postData = Yii::$app->request->post();
        if (!Yii::$app->request->isAjax || empty($postData) || !empty($postData['prev'])) {
            return [];
        }

        if (empty($step)) {
            return $this->_validateAllModels();

        } else {
            $modelName = $this->_getModelNameByStep($step);

            $model = new $modelName;
            if ($model->load($postData)) {
                $errors = ActiveForm::validate($model);
                $errors = $this->_checkCompanyContacts($postData, $errors);

                return $errors;
            }
        }

        return [];
    }

    /**
     * @param string $step
     *
     * @return mixed
     */
    private function _getModelNameByStep($step)
    {
        return 'frontend\\modules\\dashboard\\forms\\company\\' . ucfirst($step);
    }
}
