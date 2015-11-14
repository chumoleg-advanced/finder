<?php

namespace frontend\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class AutoPartForm extends AutoServiceForm
{
    public $delivery;
    public $deliveryAddress;

    public $condition = [];
    public $original = [];

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'delivery'        => 'Необходима доставка',
            'deliveryAddress' => 'Адрес доставки',
            'condition'       => 'Состояние',
            'original'        => 'Оригинальность',
        ]);
    }
}
