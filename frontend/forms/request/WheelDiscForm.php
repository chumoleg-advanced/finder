<?php

namespace frontend\forms\request;

use Yii;
use yii\helpers\ArrayHelper;

class WheelDiscForm extends RepairDiscForm
{
    public $priceFrom;
    public $priceTo;

    public $manufacturer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['priceFrom', 'priceTo'], 'double', 'min' => 0],
            [['manufacturer'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'priceFrom'    => 'Стоимость от',
            'priceTo'      => 'Стоимость до',
            'manufacturer' => 'Производитель'
        ]);
    }
}
