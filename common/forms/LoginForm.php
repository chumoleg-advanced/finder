<?php

namespace common\forms;

use common\components\Role;
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
            $user = $this->getUser();
            if (empty($user)) {
                $this->signUp();
            }

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

    /**
     * @return User|null
     */
    public function signUp()
    {
        if ($this->hasErrors()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            Role::assignRoleForUser($user);
            return $user;
        }

        return null;
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (!empty($user) && !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный пароль');
        }
    }
}
