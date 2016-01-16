<?php

namespace frontend\searchForms;

use Yii;
use yii\base\Model;
use common\models\request\Request;

class BaseForm extends Model
{
    public $verifyCode;
    public $delivery;
    public $deliveryAddress;
    public $addressCoordinates;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
            [['verifyCode', 'delivery', 'deliveryAddress', 'addressCoordinates'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'description'        => 'Описание',
            'comment'            => 'Комментарий',
            'image'              => 'Фото',
            'partsCondition'     => 'Состояние',
            'partsOriginal'      => 'Оригинальность',
            'verifyCode'         => 'Проверочный код',
            'delivery'           => 'Необходима доставка',
            'deliveryAddress'    => 'Адрес доставки',
            'addressCoordinates' => 'Координаты адреса'
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
        if (!$this->validate()) {
            return false;
        }

        $attributes = $this->attributes;
        unset($attributes['verifyCode']);
        unset($attributes['delivery']);

        return (new Request())->createModelFromPost($rubricId, $attributes, $queryArrayFormData);
    }
}