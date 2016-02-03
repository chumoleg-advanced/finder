<?php

namespace frontend\modules\dashboard\forms\company;

use yii\base\Model;
use yii\helpers\ArrayHelper;

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

    public function attributeLabels()
    {
        return [
            'city_id'            => 'Город',
            'address'            => 'Адрес',
            'addressCoordinates' => 'Координаты',
            'timeWork'           => 'Время работы',
        ];
    }

    public function checkTimeWork()
    {
        $workDays = ArrayHelper::getValue($this->timeWork, '0.days');
        $holidays = ArrayHelper::getValue($this->timeWork, '1.days');
        if (empty($workDays) && empty($holidays)) {
            $this->addError('timeWork[0][days]', 'Время работы указано некорректно!');
        }

        foreach ($this->timeWork as $items) {
            if (empty($items['days'])) {
                continue;
            }

            $timeFrom = (int)ArrayHelper::getValue($items, 'timeFrom');
            $timeTo = (int)ArrayHelper::getValue($items, 'timeTo');
            if ($timeFrom >= $timeTo) {
                $this->addError('timeWork[0][days]', 'Время работы указано некорректно!');
                break;
            }
        }
    }
}
