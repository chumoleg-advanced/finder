<?php

namespace frontend\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class RepairDiscForm extends BaseForm
{
    public $discType;
    public $diameter;
    public $points;
    public $width;
    public $out;
    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['discType', 'diameter', 'points', 'count'], 'required'],
            [['width', 'out'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'discType' => 'Типы дисков',
            'diameter' => 'Диаметр',
            'points'   => 'Сверловка',
            'width'    => 'Ширина',
            'out'      => 'Вылет',
            'count'    => 'Кол-во',
        ]);
    }
}
