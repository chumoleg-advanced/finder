<?php

namespace app\modules\dashboard\forms\company;

use yii\base\Model;

class ContactData extends Model
{
    public $address;
    public $addressCoordinates;
    public $contactDataValues;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address'], 'required'],
            [['addressCoordinates'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'address'            => 'Адрес',
            'addressCoordinates' => 'Координаты'
        ];
    }
}
