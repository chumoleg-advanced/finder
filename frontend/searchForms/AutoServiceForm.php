<?php

namespace frontend\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class AutoServiceForm extends BaseForm
{
    public $carFirm;
    public $carModel;
    public $carBody;
    public $carMotor;

    public $vinNumber;
    public $yearRelease;
    public $drive;
    public $transmission;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['description', 'carFirm'], 'required']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'carFirm'      => 'Марка',
            'carModel'     => 'Модель',
            'carBody'      => 'Кузов',
            'carMotor'     => 'Двигатель',
            'vinNumber'    => 'VIN или FRAME',
            'yearRelease'  => 'Год выпуска',
            'drive'        => 'Привод',
            'transmission' => 'Коробка передач'
        ]);
    }
}
