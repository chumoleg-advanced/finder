<?php

namespace common\components;

class CarData
{
    public static $driveList
        = [
            1 => 'Передний',
            2 => 'Задний',
            3 => '4WD',
        ];

    public static $transmissionList
        = [
            1 => 'Механическая',
            2 => 'Автоматическая',
            3 => 'Вариатор',
            4 => 'Робот',
        ];

    public static $discTypeList
        = [
            1 => 'Литые',
            2 => 'Кованные',
            3 => 'Штампованные',
        ];

    public static $tireTypeList
        = [
            1 => 'Летние',
            2 => 'Зимние',
            3 => 'Всесезонные',
        ];

    public static $tireTypeWinterList
        = [
            1 => 'Шипованные',
            2 => 'Нешипованные',
            3 => 'Под шипы',
        ];

    public static $partsCondition
        = [
            1 => 'Новая',
            2 => 'Контракт',
            3 => 'Б/у',
        ];

    public static $wheelCondition
        = [
            1 => 'Новые',
            3 => 'Б/у',
        ];

    public static $partsOriginal
        = [
            1 => 'Оригинал',
            2 => 'Дубликат'
        ];

    public static $availability =  [1 => 'В наличии', 2 => 'Под заказ'];

    /**
     * @return array
     */
    public static function getYearRelease()
    {
        $data = range(date('Y'), 1970);
        return array_combine($data, $data);
    }
}