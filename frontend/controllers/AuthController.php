<?php

namespace frontend\controllers;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\authclient\BaseClient;
use common\models\auth\Oauth;
use common\models\user\User;
use common\components\Json;
use common\forms\LoginForm;
use yii\web\Response;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return Json::STATUS_SUCCESS;
        }

        $model = new LoginForm();
        $answer = Json::STATUS_ERROR;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $answer = Json::STATUS_SUCCESS;
        }

        return $answer;
    }

    /**
     * @param BaseClient $client
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $auth Oauth */
        $auth = Oauth::find()->where([
            'source'    => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // signup
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app',
                            "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.",
                            ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $attributes['login'],
                        'email'    => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Oauth([
                            'user_id'   => $user->id,
                            'source'    => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Oauth([
                    'user_id'   => Yii::$app->user->id,
                    'source'    => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }
}
