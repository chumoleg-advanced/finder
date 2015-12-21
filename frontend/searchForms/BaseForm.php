<?php

namespace app\searchForms;

use Yii;
use yii\base\Model;

class BaseForm extends Model
{
    public $withMe;
    public $districtData;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'withMe'       => 'Рядом со мной',
            'districtData' => 'Районы',
            'verifyCode'   => 'Проверочный код'
        ];
    }

    /**
     * @return bool
     */
    public function submitForm()
    {
        if ($this->validate()) {
            // @TODO создаем заявку здесь
            return true;
        }

        return false;
    }
}