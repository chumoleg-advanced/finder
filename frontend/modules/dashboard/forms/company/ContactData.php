<?php

namespace frontend\modules\dashboard\forms\company;

use yii\base\Model;

class ContactData extends Model
{
    public $address;
    public $city_id;
    public $addressCoordinates;
    public $contactDataValues;
    public $timeWork = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'city_id'], 'required'],
            [['city_id'], 'integer'],
            ['timeWork', 'checkTimeWork'],
            [['addressCoordinates'], 'safe'],
        ];
    }

    public function checkTimeWork()
    {
        if (empty($this->timeWork['workdays']) && empty($this->timeWork['holidays'])){
            $this->addError('timeWork[workdays]', 'Заполните время работы');
        }
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
