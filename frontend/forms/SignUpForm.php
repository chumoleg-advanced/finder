<?php
namespace frontend\forms;

use common\models\notification\Notification;
use common\models\notification\NotificationSetting;
use Yii;
use common\components\Role;
use common\models\user\User;
use yii\base\Model;

class SignUpForm extends Model
{
    public $email;
    public $password;
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'confirmPassword'], 'filter', 'filter' => 'trim'],
            [['email', 'password', 'confirmPassword'], 'required'],
            [
                'email',
                'unique',
                'targetClass' => 'common\models\user\User',
                'message'     => 'Указанный email уже занят'
            ],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['confirmPassword', 'checkConfirmPassword']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'           => 'E-mail',
            'password'        => 'Пароль',
            'confirmPassword' => 'Подтвердите пароль',
        ];
    }

    public function checkConfirmPassword($attribute, $params)
    {
        if ($this->password != $this->confirmPassword) {
            $this->addError($attribute, 'Пароли не совпадают');
        }

        return true;
    }

    /**
     * @return bool
     */
    public function signUp()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            Role::assignRoleForUser($user);
            foreach (Notification::$typeListForUser as $type => $name) {
                NotificationSetting::manage($user->id, $type);
            }
            
            return Yii::$app->user->login($user);
        }

        return false;
    }
}
