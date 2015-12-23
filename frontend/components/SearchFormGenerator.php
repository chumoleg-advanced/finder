<?php

namespace app\components;

use common\components\ActiveField;
use kartik\form\ActiveForm;
use yii\helpers\Url;

class SearchFormGenerator
{
    const FORM_ID = 'request-form';

    /**
     * @param int $formId
     *
     * @return ActiveForm
     */
    public static function getFormFiles($formId)
    {
        $params = self::_getCommonParams($formId);
        $params['options'] = [
            'enctype' => 'multipart/form-data',
            'id'      => self::FORM_ID
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
            'validationUrl'          => Url::to(['/ajax/search/validate', 'id' => $formId]),
            'formConfig'             => [
                'showLabels' => false,
                'deviceSize' => ActiveForm::SIZE_MEDIUM,
            ],
            'fieldConfig'            => [
                'template' => "{input}\n{hint}\n{error}",
                'class'    => ActiveField::className()
            ],
            'options'                => [
                'data-pjax' => true
            ],
        ];
    }

    /**
     * @param int $formId
     *
     * @return ActiveForm
     */
    public static function getFormSingle($formId)
    {
        $params = self::_getCommonParams($formId);
        $params['id'] = self::FORM_ID;

        return ActiveForm::begin($params);
    }
}