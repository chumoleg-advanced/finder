<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;

/**
 * This is the model class for table "company_address".
 *
 * @property integer              $id
 * @property integer              $company_id
 * @property string               $address
 * @property string               $map_coordinates
 * @property string               $time_work
 * @property string               $date_create
 *
 * @property Company              $company
 * @property CompanyContactData[] $companyContactDatas
 */
class CompanyAddress extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'address'], 'required'],
            [['company_id'], 'integer'],
            [['time_work'], 'string'],
            [['date_create'], 'safe'],
            [['address'], 'string', 'max' => 400],
            [['map_coordinates'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'company_id'      => 'Company ID',
            'address'         => 'Address',
            'map_coordinates' => 'Map Coordinates',
            'time_work'       => 'Time Work',
            'date_create'     => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyAddressQuery(get_called_class());
    }

    /**
     * @param $companyId
     * @param $contactData
     * @param $timeWork
     *
     * @return int
     */
    public static function create($companyId, $contactData, $timeWork)
    {
        $address = new self();
        $address->company_id = $companyId;
        $address->address = $contactData->address;
        $address->map_coordinates = $contactData->addressCoordinates;
        $address->time_work = $timeWork;
        $address->save();

        return $address->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyContactDatas()
    {
        return $this->hasMany(CompanyContactData::className(), ['company_address_id' => 'id']);
    }
}
