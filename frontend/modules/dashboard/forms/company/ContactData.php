<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class ContactData extends Model
{
    public $address;
    public $contactDataValues;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'address'     => 'Адрес',
        ];
    }
}
