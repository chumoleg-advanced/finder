<?php

namespace frontend\controllers;

use common\components\Role;
use common\models\user\User;
use Yii;
use frontend\forms\ContactForm;
use frontend\components\Controller;
use common\models\category\Category;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($this->action->id != 'error' && !Yii::$app->user->isGuest && User::getUserRole(Yii::$app->user->getId()) == Role::USER) {
                $this->redirect(Yii::$app->homeUrl);
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'     => 'frontend\components\CaptchaAction',
                'minLength' => 5,
                'maxLength' => 7,
                'height'    => 50,
                'width'     => 210,
                'testLimit' => 0
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = Category::find()->whereId([1, 2])->all();
        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success',
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}