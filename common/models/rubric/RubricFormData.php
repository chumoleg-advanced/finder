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
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => 'AutoServiceForm',
            6 => null,
            7 => null
        ];

        $className = ArrayHelper::getValue($viewsList, $formId);
        if (empty($className)) {
            $className = 'DefaultForm';
        }

        return '\\frontend\\searchForms\\' . $className;
    }
}
