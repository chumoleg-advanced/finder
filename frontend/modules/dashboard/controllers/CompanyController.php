<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\components\Controller;
use beastbytes\wizard\WizardBehavior;
use beastbytes\wizard\StepEvent;
use yii\web\NotFoundHttpException;

class CompanyController extends Controller
{
    public function beforeAction($action)
    {
        $this->attachBehavior('wizard', [
            'class'  => WizardBehavior::className(),
            'steps'  => [
                'Общая информация'   => 'mainData',
                'Сфера деятельности' => 'rubricData',
                'Контактные данные'  => 'contactData'
            ],
            'events' => [
                WizardBehavior::EVENT_WIZARD_STEP  => [$this, 'registrationWizardStep'],
                WizardBehavior::EVENT_AFTER_WIZARD => [$this, 'registrationAfterWizard'],
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
    public function registrationWizardStep($event)
    {
        if (!in_array($event->step, $this->steps)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        if (empty($event->stepData)) {
            $modelName = 'app\\modules\\dashboard\\forms\\company\\' . ucfirst($event->step);
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

        } else {
            $event->data = $this->render('create/' . $event->step, compact('event', 'model'));
        }
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
    public function registrationAfterWizard($event)
    {
        if ($event->step) {
            $event->data = $this->render('complete', ['data' => $event->stepData]);
        } else {
            $this->redirect(['create']);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', []);
    }
}
