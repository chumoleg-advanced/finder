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
            2 => 'Автоматическая'
        ];

    public static $discTypeList
        = [
            1 => 'Литые',
            2 => 'Кованные',
            3 => 'Штампованные',
        ];

    public static $partsCondition
        = [
            1 => 'Новая',
            2 => 'Контракт',
            3 => 'Б/у',
        ];

    public static $partsOriginal
        = [
            1 => 'Оригинал',
            2 => 'Дубликат',
            3 => 'Любая',
        ];
}