<?php

namespace common\models\rubric;

use Yii;
use yii\helpers\ArrayHelper;

class RubricFormData
{
    /**
     * @param int $formId
     *
     * @return string
     */
    public static function getViewName($formId)
    {
        $viewsList = [
            1 => 'import_auto_parts',
            2 => 'russian_auto_parts',
            3 => 'tires',
            4 => 'wheel_disc',
            5 => 'auto_service',
            6 => 'repair_discs',
            7 => 'repair_car_body'
        ];

        return ArrayHelper::getValue($viewsList, $formId, 'default');
    }

    /**
     * @param $formId
     *
     * @return string
     */
    public static function geFormModel($formId)
    {
        $viewsList = [
            1 => 'AutoPartForm',
            2 => 'AutoPartForm',
            3 => 'TireForm',
            4 => 'WheelDiscForm',
            5 => 'AutoServiceForm',
            6 => 'RepairDiscForm',
            7 => 'RepairCarBodyForm'
        ];

        $className = ArrayHelper::getValue($viewsList, $formId);
        if (empty($className)) {
            $className = 'DefaultForm';
        }

        return 'app\\searchForms\\' . $className;
    }
}
