<?php

namespace frontend\modules\dashboard\forms\company;

use common\models\company\Company;
use Yii;
use yii\base\Model;

class MainData extends Model
{
    const FORM_JURIDICAL = 1;
    const FORM_INDIVIDUAL = 2;
    const FORM_PHYSICAL = 3;

    public $form;
    public $legal_name;
    public $actual_name;
    public $inn;
    public $ogrn;
    public $ogrnip;
    public $fio;
    public $companyId;

    /**
     * @return array
     */
    public static function getFormList()
    {
        return [
            self::FORM_JURIDICAL  => 'Юр. лицо',
            self::FORM_INDIVIDUAL => 'ИП',
            self::FORM_PHYSICAL   => 'Физ. лицо'
        ];
    }

    /**
     * @return array
     */
    public static function getWeekDays()
    {
        return [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс'
        ];
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return array
     */
    public static function getRange($from = 0, $to = 24)
    {
        $data = range($from, $to);

        return array_combine($data, $data);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['legal_name', 'actual_name', 'fio', 'inn', 'ogrn', 'ogrnip'], 'filter', 'filter' => 'trim'],
            [['form', 'inn', 'legal_name', 'fio', 'actual_name'], 'required'],
            [['legal_name', 'actual_name', 'fio'], 'string', 'max' => 250],
            [['form', 'companyId'], 'integer'],
            [['inn'], 'checkUniqueInn'],
            [['inn', 'ogrn'], 'double'],
            ['inn', 'string', 'length' => [10, 12]],
            ['ogrn', 'string', 'length' => [15, 15]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'form'        => 'Форма организации',
            'legal_name'  => 'Юридическое название',
            'actual_name' => 'Фактическое название',
            'fio'         => 'ФИО',
            'inn'         => 'ИНН',
            'ogrn'        => 'ОГРН',
            'ogrnip'      => 'ОГРНИП'
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->form == self::FORM_INDIVIDUAL) {
            $this->ogrn = $this->ogrnip;
        }

        if ($this->form == self::FORM_PHYSICAL) {
            $this->legal_name = $this->fio;
            $this->actual_name = null;
            $this->ogrn = null;

        } else {
            $this->fio = $this->legal_name;
        }

        if (empty($this->actual_name)){
            $this->actual_name = $this->legal_name;
        }

        return parent::beforeValidate();
    }

    public function checkUniqueInn($attribute, $params)
    {
        $query = Company::find()->andWhere(['inn' => $this->inn]);
        if (!empty($this->companyId)) {
            $query->andWhere(['!=', 'id', $this->companyId]);
        }

        $check = $query->one();
        if (!empty($check)) {
            $this->addError($attribute, 'Указанный ИНН уже занят!');
        }

        return true;
    }
}
