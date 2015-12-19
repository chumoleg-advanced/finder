<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class WheelDiscForm extends RepairDiscForm
{
    public $delivery;
    public $deliveryAddress;
    public $priceFrom;
    public $priceTo;

    public $description;
    public $manufacturer;
    public $condition;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'diameter', 'points', 'count'], 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'delivery'        => 'Необходима доставка',
            'deliveryAddress' => 'Адрес доставки',
            'priceFrom'       => 'Стоимость от',
            'priceTo'         => 'Стоимость до',
            'condition'       => 'Состояние',
            'manufacturer'    => 'Производитель',
            'description'     => 'Описание'
        ]);
    }
}
