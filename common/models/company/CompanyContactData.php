<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;

/**
 * This is the model class for table "company_contact_data".
 *
 * @property integer        $id
 * @property integer        $company_id
 * @property integer        $company_address_id
 * @property integer        $type
 * @property string         $data
 * @property string         $date_create
 *
 * @property CompanyAddress $companyAddress
 * @property Company        $company
 */
class CompanyContactData extends ActiveRecord
{
    public static $typeList
        = [
            1  => 'Телефон',
            2  => 'Факс',
            3  => 'E-mail',
            4  => 'Адрес сайта',
            5  => 'Skype',
            6  => 'ICQ',
            7  => 'Jabber',
            8  => 'Вконтакте',
            9  => 'Facebook',
            10 => 'Instagram',
            11 => 'Twitter',
            12 => 'LinkedIn'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_contact_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'company_address_id', 'type'], 'required'],
            [['company_id', 'company_address_id', 'type'], 'integer'],
            [['date_create'], 'safe'],
            [['data'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'company_id'         => 'Company ID',
            'company_address_id' => 'Company Address ID',
            'type'               => 'Type',
            'data'               => 'Data',
            'date_create'        => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyContactDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyContactDataQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getGroupedTypeList()
    {
        return [
            'Контакты'        => array_intersect_key(self::$typeList, [1, 2, 3, 4, 5, 6, 7]),
            'Социальные сети' => array_intersect_key(self::$typeList, [8, 9, 10, 11, 12])
        ];
    }

    /**
     * @param $companyId
     * @param $addressId
     * @param $type
     * @param $value
     */
    public static function create($companyId, $addressId, $type, $value)
    {
        $rel = new self();
        $rel->company_id = $companyId;
        $rel->company_address_id = $addressId;
        $rel->type = $type;
        $rel->data = $value;
        $rel->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddress()
    {
        return $this->hasOne(CompanyAddress::className(), ['id' => 'company_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
