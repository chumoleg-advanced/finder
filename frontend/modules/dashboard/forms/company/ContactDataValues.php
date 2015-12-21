<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class ContactDataValues extends Model
{
    public $typeData;
    public $valueData;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeData', 'valueData'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'typeData'  => 'Тип',
            'valueData' => 'Значение',
        ];
    }
}
