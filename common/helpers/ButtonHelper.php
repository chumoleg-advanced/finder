<?php

namespace common\helpers;

use Yii;
use \yii\helpers\Html;

class ButtonHelper
{
    public static function getSubmitButton($model)
    {
        return Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    }
}