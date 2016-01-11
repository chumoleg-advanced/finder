<?php

namespace frontend\modules\dashboard\forms\company;

use yii\base\Model;

class RubricData extends Model
{
    public $typePayment;
    public $typeDelivery;
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
            'rubrics'      => 'Сферы деятельности'
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->rubrics = array_filter((array)$this->rubrics, function ($val) {
            return !empty($val);
        });

        return parent::beforeValidate();
    }
}
