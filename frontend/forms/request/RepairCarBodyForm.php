<?php

namespace frontend\forms\request;

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

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['color'], 'safe']
        ]);
    }
}
