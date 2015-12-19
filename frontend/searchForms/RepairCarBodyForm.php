<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class RepairCarBodyForm extends AutoServiceForm
{
    public $color;

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'color' => 'Цвет',
        ]);
    }
}
