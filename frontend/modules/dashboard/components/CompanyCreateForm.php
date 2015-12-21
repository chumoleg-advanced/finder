<?php

namespace app\modules\dashboard\components;

use Yii;
use kartik\form\ActiveForm;
use yii\helpers\Url;

class CompanyCreateForm
{
    /**
     * @param string $step
     * @param array  $options
     *
     * @return ActiveForm
     */
    public static function getForm($step = 'mainData', $options = [])
    {
        return ActiveForm::begin([
            'type'                   => ActiveForm::TYPE_VERTICAL,
            'validateOnBlur'         => false,
            'validateOnChange'       => true,
            'enableAjaxValidation'   => true,
            'enableClientValidation' => false,
            'validationUrl'          => Url::to(['company/validate', 'step' => $step]),
            'formConfig'             => [
                'deviceSize' => ActiveForm::SIZE_MEDIUM,
            ],
            'options'                => $options
        ]);
    }
}