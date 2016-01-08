<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\user\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password = '';
    public $rememberMe = true;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'filter', 'filter' => 'trim'],
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'      => 'Email',
            'password'   => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * @return null|User
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (!$user) {
            $this->addError('email', 'Указанный email не зарегистрирован или заблокирован');
            return;
        }

        $user = $this->getUser();
        if (!empty($user) && !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный пароль');
        }
    }
}
