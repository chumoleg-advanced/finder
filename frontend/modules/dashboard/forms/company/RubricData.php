<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class RubricData extends Model
{
    public $typePayment;
    public $typeDelivery;
    public $timeWork;
    public $rubrics;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typePayment', 'typeDelivery', 'rubrics'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'typePayment'  => 'Способы оплаты',
            'typeDelivery' => 'Способы доставки',
            'timeWork'     => 'Время работы',
            'rubrics'      => 'Сферы деятельности'
        ];
    }
}
