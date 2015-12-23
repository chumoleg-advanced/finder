<?php

namespace app\searchForms;

use Yii;
use yii\base\Model;
use common\models\request\Request;

class BaseForm extends Model
{
    public $verifyCode;
    public $delivery;
    public $deliveryAddress;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
            [['verifyCode', 'delivery', 'deliveryAddress'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'verifyCode'      => 'Проверочный код',
            'delivery'        => 'Необходима доставка',
            'deliveryAddress' => 'Адрес доставки'
        ];
    }

    /**
     * @param $rubricId
     * @param $queryArrayFormData
     *
     * @return bool
     */
    public function submitForm($rubricId, $queryArrayFormData)
    {
        if (!$this->validate()){
            return false;
        }

        $attributes = $this->attributes;
        unset($attributes['verifyCode']);
        unset($attributes['delivery']);

        return (new Request())->createModelFromPost($rubricId, $attributes, $queryArrayFormData);
    }
}