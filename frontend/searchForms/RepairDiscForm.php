<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class RepairDiscForm extends BaseForm
{
    public $type;
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
            [['type', 'diameter', 'points', 'count'], 'required'],
            [['width', 'out'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'type'     => 'Тип диска',
            'diameter' => 'Диаметр',
            'points'   => 'Сверловка',
            'width'    => 'Ширина',
            'out'      => 'Вылет',
            'count'    => 'Кол-во',
        ]);
    }
}
