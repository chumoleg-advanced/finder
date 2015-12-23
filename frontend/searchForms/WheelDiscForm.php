<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class WheelDiscForm extends RepairDiscForm
{
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
        return ArrayHelper::merge(parent::rules(), [
            [['description', 'manufacturer', 'condition'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'priceFrom'     => 'Стоимость от',
            'priceTo'       => 'Стоимость до',
            'condition' => 'Состояние',
            'manufacturer'  => 'Производитель',
            'description'   => 'Описание'
        ]);
    }
}
