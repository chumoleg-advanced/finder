<?php

namespace app\modules\dashboard\forms\company;

use common\models\category\Category;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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
            [['typePayment', 'typeDelivery', 'rubrics', 'timeWork'], 'required']
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

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        return parent::beforeValidate();
    }
}
