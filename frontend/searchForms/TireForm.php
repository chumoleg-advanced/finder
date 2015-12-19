<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class TireForm extends BaseForm
{
    public $description;

    public $type;
    public $typeWinter = [];

    public $diameter;
    public $width;
    public $height;
    public $count;

    public $delivery;
    public $deliveryAddress;
    public $priceFrom;
    public $priceTo;

    public $manufacturer;
    public $condition = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['diameter', 'width', 'height', 'type', 'count', 'condition'], 'required']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'type'            => 'Тип шин',
            'typeWinter'      => 'Тип зимних шин',
            'diameter'        => 'Диаметр',
            'width'           => 'Ширина',
            'height'          => 'Высота',
            'count'           => 'Кол-во',
            'delivery'        => 'Необходима доставка',
            'deliveryAddress' => 'Адрес доставки',
            'priceFrom'       => 'Стоимость от',
            'priceTo'         => 'Стоимость до',
            'condition'       => 'Состояние',
            'manufacturer'    => 'Производитель',
        ]);
    }
}
