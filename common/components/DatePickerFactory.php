<?php

namespace common\components;

use \yii\jui\DatePicker;

class DatePickerFactory
{
    /**
     * @param        $searchModel
     * @param string $attribute
     *
     * @return string
     * @throws \Exception
     */
    public static function getInput($searchModel, $attribute)
    {
        return DatePicker::widget([
            'model'         => $searchModel,
            'attribute'     => $attribute,
        ]);
    }
}