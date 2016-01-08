<?php

namespace app\controllers;

use app\forms\PasswordResetRequestForm;
use app\forms\ResetPasswordForm;
use app\forms\SignUpForm;
use kartik\form\ActiveForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use common\forms\LoginForm;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actionLoginValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!\Yii::$app->user->isGuest) {
            return [];
        }

        $errors = [];
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $errors = ActiveForm::validate($model);
        }

        return $errors;
    }

    /**
     * @return array
     */
    public function actionSignupValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!\Yii::$app->user->isGuest) {
            return [];
        }

        $errors = [];
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post())) {
            $errors = ActiveForm::validate($model);
        }

        return $errors;
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
