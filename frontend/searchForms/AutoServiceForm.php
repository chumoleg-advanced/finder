<?php

namespace frontend\searchForms;

use Yii;
use yii\base\Model;

class AutoServiceForm extends Model
{
    public $subjectData;

    public $carFirm;
    public $carModel;
    public $carBody;
    public $carMotor;

    public $vinNumber;
    public $yearRelease;
    public $drive;
    public $transmission;

    public $withMe;
    public $districtData;

    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subjectData', 'carFirm'], 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'carFirm'      => 'Марка',
            'carModel'     => 'Модель',
            'carBody'      => 'Кузов',
            'carMotor'     => 'Двигатель',
            'vinNumber'    => 'VIN или FRAME',
            'yearRelease'  => 'Год выпуска',
            'drive'        => 'Привод',
            'transmission' => 'Коробка передач',
            'withMe'       => 'Рядом со мной',
            'districtData' => 'Районы',
        ];
    }
}
