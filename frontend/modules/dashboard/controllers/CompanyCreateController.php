<?php

namespace frontend\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;
use beastbytes\wizard\WizardBehavior;
use beastbytes\wizard\StepEvent;
use yii\web\NotFoundHttpException;
use common\models\company\Company;

class CompanyCreateController extends Controller
{
    public function getViewPath()
    {
        return '@app/modules/dashboard/views/company';
    }

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
    public function actionIndex($step = null)
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
            $modelName = $this->_getModelNameByStep($event->step);
            $model = new $modelName();
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

            if (isset($post['CompanyContactData'])) {
                $event->data['contactDataValues'] = $post['CompanyContactData'];
            }

        } else {
            $event->data = $this->render('create/' . $event->step, compact('event', 'model'));
        }
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
     *
     * @throws NotFoundHttpException
     */
    public function createAfterWizard($event)
    {
        if ($event->step) {
            $model = new Company();
            if (!$model->createByStepData($event->stepData)) {
                throw new NotFoundHttpException('Ошибка при сохранении компании!');
            }

            $this->redirect(['result']);

        } else {
            $this->redirect(['index']);
        }
    }

    public function actionResult()
    {
        return $this->render('result');
    }
}
