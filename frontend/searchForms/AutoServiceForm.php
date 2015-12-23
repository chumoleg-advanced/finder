<?php

namespace app\searchForms;

use Yii;
use yii\helpers\ArrayHelper;

class AutoServiceForm extends BaseForm
{
    public $carFirm;
    public $carModel;
    public $carBody;
    public $carEngine;

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
            [['carFirm', 'carModel'], 'required'],
            [['carBody', 'carEngine', 'vinNumber', 'yearRelease', 'drive', 'transmission'], 'safe']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'carFirm'      => 'Марка',
            'carModel'     => 'Модель',
            'carBody'      => 'Кузов',
            'carEngine'    => 'Двигатель',
            'vinNumber'    => 'VIN или FRAME',
            'yearRelease'  => 'Год выпуска',
            'drive'        => 'Привод',
            'transmission' => 'Коробка передач'
        ]);
    }
}
