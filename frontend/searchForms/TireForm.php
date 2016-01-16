<?php

namespace frontend\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class TireForm extends BaseForm
{
    public $tireType;
    public $tireTypeWinter = [];

    public $diameter;
    public $width;
    public $height;
    public $count;

    public $priceFrom;
    public $priceTo;

    public $manufacturer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['diameter', 'width', 'height', 'tireType', 'count'], 'required'],
            [['priceFrom', 'priceTo'], 'double', 'min' => 0],
            [['manufacturer', 'tireTypeWinter'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'tireType'       => 'Типы шин',
            'tireTypeWinter' => 'Типы зимних шин',
            'diameter'       => 'Диаметр',
            'width'          => 'Ширина',
            'height'         => 'Высота',
            'count'          => 'Кол-во',
            'priceFrom'      => 'Стоимость от',
            'priceTo'        => 'Стоимость до',
            'manufacturer'   => 'Производитель',
        ]);
    }
}
