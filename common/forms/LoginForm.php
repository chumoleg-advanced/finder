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
    public $password;
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

    public function afterValidate()
    {
        parent::afterValidate();

        $user = $this->getUser();
        if (empty($user)) {
            $this->signUp(false);
        }

        return true;
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
     * @param bool|true $validate
     *
     * @return User|null
     */
    public function signUp($validate = true)
    {
        if ($validate && !$this->validate()) {
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

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate() && $this->validatePassword()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    public function validatePassword()
    {
        $user = $this->getUser();
        if ($user && !$user->validatePassword($this->password)) {
            $this->addError('password', 'Неверный пароль');
            return false;
        }

        return true;
    }
}
