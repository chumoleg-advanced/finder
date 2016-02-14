<?php
namespace frontend\modules\dashboard\forms\user;

use Yii;
use common\models\user\User;
use common\components\Model;

class UserDataForm extends Model
{
    public $userId;

    public $email;
    public $fio;
    public $phone;
    public $birthday;

    public $password;
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'fio', 'phone', 'password', 'confirmPassword'], 'filter', 'filter' => 'trim'],
            [['email', 'userId'], 'required'],
            [['email'], 'checkUniqueEmail'],
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
            'phone'           => 'Телефон',
            'fio'             => 'ФИО',
            'birthday'        => 'Дата рождения',
            'password'        => 'Пароль',
            'confirmPassword' => 'Подтвердите пароль',
        ];
    }

    public function checkUniqueEmail($attribute, $params)
    {
        $query = User::find()->andWhere(['email' => $this->email]);
        if (!empty($this->userId)) {
            $query->andWhere(['!=', 'id', $this->userId]);
        }

        $check = $query->one();
        if (!empty($check)) {
            $this->addError($attribute, 'Указанный E-mail уже занят!');
        }

        return true;
    }

    public function checkConfirmPassword($attribute, $params)
    {
        if ($this->password != $this->confirmPassword) {
            $this->addError($attribute, 'Пароли не совпадают');
        }

        return true;
    }

    public function beforeValidate()
    {
        $this->phone = str_replace([' ', '(', ')', '-'], '', $this->phone);
        return parent::beforeValidate();
    }

    /**
     * @return bool
     */
    public function saveForm()
    {
        if (!$this->validate()) {
            return false;
        }

        $userModel = User::findById($this->userId);
        if (empty($userModel)) {
            return false;
        }

        $userModel->setAttributes($this->attributes);

        if (!empty($this->password)) {
            $userModel->setPassword($this->password);
            $userModel->generateAuthKey();
        }

        return $userModel->save();
    }
}
