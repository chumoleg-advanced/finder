<?php

namespace frontend\components;

use \kartik\form\ActiveForm;
use yii\helpers\Url;

class ActiveFormGenerator
{
    /**
     * @param int    $formId
     * @param string $htmlId
     *
     * @return ActiveForm
     */
    public static function getFormFiles($formId, $htmlId = 'auto-service-form')
    {
        $params = self::_getCommonParams($formId);
        $params['options'] = [
            'enctype' => 'multipart/form-data',
            'id'      => $htmlId
        ];

        return ActiveForm::begin($params);
    }

    /**
     * @param int $formId
     *
     * @return array
     */
    private static function _getCommonParams($formId)
    {
        return [
            'type'                   => ActiveForm::TYPE_HORIZONTAL,
            'validateOnBlur'         => false,
            'validateOnChange'       => true,
            'enableAjaxValidation'   => true,
            'enableClientValidation' => false,
            'validationUrl'          => Url::to(['search/validate', 'id' => $formId]),
            'formConfig'             => [
                'showLabels' => false,
                'deviceSize' => ActiveForm::SIZE_MEDIUM
            ],
            'fieldConfig'            => [
                'template' => "{input}\n{hint}\n{error}",
            ],
        ];
    }

    /**
     * @param int    $formId
     * @param string $htmlId
     *
     * @return ActiveForm
     */
    public static function getFormSingle($formId, $htmlId)
    {
        $params = self::_getCommonParams($formId);
        $params['id'] = $htmlId;

        return ActiveForm::begin($params);
    }
}