<?php

namespace frontend\components;

use \kartik\form\ActiveForm;

class ActiveFormGenerator
{
    /**
     * @param string $id
     *
     * @return ActiveForm
     */
    public static function getFormFiles($id = 'auto-service-form')
    {
        return ActiveForm::begin([
            'type'           => ActiveForm::TYPE_HORIZONTAL,
            'validateOnBlur' => false,
            'formConfig'     => [
                'showLabels' => false,
                'deviceSize' => ActiveForm::SIZE_MEDIUM
            ],
            'fieldConfig'    => [
                'template' => "{input}\n{hint}\n{error}",
            ],
            'options'        => [
                'enctype' => 'multipart/form-data',
                'id'      => $id
            ],
        ]);
    }

    /**
     * @param string $id
     *
     * @return ActiveForm
     */
    public static function getFormSingle($id)
    {
        return ActiveForm::begin([
            'id'             => $id,
            'type'           => ActiveForm::TYPE_HORIZONTAL,
            'validateOnBlur' => false,
            'formConfig'     => [
                'showLabels' => false,
                'deviceSize' => ActiveForm::SIZE_MEDIUM
            ],
            'fieldConfig'    => [
                'template' => "{input}\n{hint}\n{error}",
            ],
        ]);
    }
}