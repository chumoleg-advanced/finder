<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\forms\company\ContactData;
use app\modules\dashboard\forms\company\ContactDataValues;
use common\components\Model;
use common\models\company\Company;
use Yii;
use app\modules\dashboard\components\Controller;
use beastbytes\wizard\WizardBehavior;
use beastbytes\wizard\StepEvent;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use kartik\form\ActiveForm;

class CompanyController extends Controller
{
    public function beforeAction($action)
    {

        $this->attachBehavior('wizard', [
            'class'  => WizardBehavior::className(),
            'steps'  => Company::getCreateStepList(),
            'events' => [
                WizardBehavior::EVENT_WIZARD_STEP  => [$this, 'createWizardStep'],
                WizardBehavior::EVENT_AFTER_WIZARD => [$this, 'createAfterWizard'],
                WizardBehavior::EVENT_INVALID_STEP => [$this, 'invalidStep']
            ]
        ]);

        return parent::beforeAction($action);
    }

    /**
     * @param null $step
     *
     * @return mixed
     */
    public function actionCreate($step = null)
    {
        return $this->step($step);
    }

    /**
     * @param StepEvent $event
     *
     * @throws NotFoundHttpException
     */
    public function createWizardStep($event)
    {
        if (!in_array($event->step, $this->steps)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        if (empty($event->stepData)) {
            $model = $this->_getModelByStep($event->step);
        } else {
            $model = $event->stepData;
        }

        $post = Yii::$app->request->post();
        if (isset($post['prev'])) {
            $event->nextStep = WizardBehavior::DIRECTION_BACKWARD;
            $event->handled = true;

        } elseif ($model->load($post) && $model->validate()) {
            $event->data = $model;
            $event->handled = true;

        } else {
            $event->data = $this->render('create/' . $event->step, compact('event', 'model'));
        }
    }

    /**
     * @param string $step
     *
     * @return mixed
     */
    private function _getModelByStep($step)
    {
        $modelName = 'app\\modules\\dashboard\\forms\\company\\' . ucfirst($step);
        return new $modelName;
    }

    /**
     * @param StepEvent $event
     */
    public function invalidStep($event)
    {
        $event->data = $this->render('invalidStep', compact('event'));
        $event->continue = false;
    }

    /**
     * @param StepEvent $event
     */
    public function createAfterWizard($event)
    {
        if ($event->step) {
            // @TODO сохраняем данные о компании здесь
//
//            \yii\helpers\VarDumper::dump($event->stepData, 10, true);
            $this->redirect(['/']);
        } else {
            $this->redirect(['create']);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', []);
    }

    public function actionValidate($step)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $postData = Yii::$app->request->post();
        if (!Yii::$app->request->isAjax || empty($postData) || empty($step)) {
            return [];
        }

        $model = $this->_getModelByStep($step);
        if ($model->load($postData)) {
            $errors = ActiveForm::validate($model);
            if (isset($postData['ContactDataValues'])) {
                $modelRows = Model::createMultiple(ContactDataValues::classname());
                Model::loadMultiple($modelRows, $postData);

                $errors += ActiveForm::validateMultiple($modelRows);
            }

            return $errors;
        }

        return [];
    }
}
