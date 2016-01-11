<?php

namespace frontend\modules\dashboard\forms\company;

use yii\base\Model;

class ContactData extends Model
{
    public $address;
    public $city_id;
    public $addressCoordinates;
    public $contactDataValues;
    public $timeWork;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'city_id', 'timeWork'], 'required'],
            [['city_id'], 'integer'],
            [['addressCoordinates'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city_id'            => 'Город',
            'address'            => 'Адрес',
            'addressCoordinates' => 'Координаты',
            'timeWork'           => 'Время работы',
        ];
    }
}
