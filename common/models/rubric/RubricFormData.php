<?php

namespace common\models\rubric;

use Yii;
use yii\helpers\ArrayHelper;

class RubricFormData
{
    const FORM_IMPORT_AUTO_PARTS = 1;
    const FORM_RUSSIAN_AUTO_PARTS = 2;
    const FORM_TIRES = 3;
    const FORM_WHEEL_DISC = 4;
    const FORM_AUTO_SERVICE = 5;
    const FORM_REPAIR_DISC = 6;
    const FORM_CAR_BODY = 7;

    /**
     * @param int $formId
     *
     * @return string
     */
    public static function getViewName($formId)
    {
        $viewsList = [
            self::FORM_IMPORT_AUTO_PARTS  => 'import_auto_parts',
            self::FORM_RUSSIAN_AUTO_PARTS => 'russian_auto_parts',
            self::FORM_TIRES              => 'tires',
            self::FORM_WHEEL_DISC         => 'wheel_disc',
            self::FORM_AUTO_SERVICE       => 'auto_service',
            self::FORM_REPAIR_DISC        => 'repair_discs',
            self::FORM_CAR_BODY           => 'repair_car_body'
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
            self::FORM_IMPORT_AUTO_PARTS  => 'AutoPartForm',
            self::FORM_RUSSIAN_AUTO_PARTS => 'AutoPartForm',
            self::FORM_TIRES              => 'TireForm',
            self::FORM_WHEEL_DISC         => 'WheelDiscForm',
            self::FORM_AUTO_SERVICE       => 'AutoServiceForm',
            self::FORM_REPAIR_DISC        => 'RepairDiscForm',
            self::FORM_CAR_BODY           => 'RepairCarBodyForm'
        ];

        $className = ArrayHelper::getValue($viewsList, $formId);
        if (empty($className)) {
            $className = 'DefaultForm';
        }

        return 'frontend\\forms\\request\\' . $className;
    }
}
