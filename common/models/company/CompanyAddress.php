<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;
use common\models\city\City;

/**
 * This is the model class for table "company_address".
 *
 * @property integer              $id
 * @property integer              $company_id
 * @property integer              $city_id
 * @property string               $address
 * @property string               $map_coordinates
 * @property string               $time_work
 * @property string               $date_create
 *
 * @property Company              $company
 * @property City                 $city
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
            [['company_id', 'city_id', 'address'], 'required'],
            [['company_id', 'city_id'], 'integer'],
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
            'city_id'         => 'Город',
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
     * @param $addressData
     *
     * @return int
     */
    public static function updateByCompany($companyId, $addressData)
    {
        $address = self::find()->andWhere(['company_id' => $companyId])->one();
        if (empty($address)) {
            return self::create($companyId, $addressData);
        }

        self::_setAttributesByForm($addressData, $address);
        $address->save();

        return $address->id;
    }

    /**
     * @param $companyId
     * @param $contactData
     *
     * @return int
     */
    public static function create($companyId, $contactData)
    {
        $address = new self();
        $address->company_id = $companyId;
        self::_setAttributesByForm($contactData, $address);
        $address->save();

        return $address->id;
    }

    /**
     * @param $addressData
     * @param $address
     */
    private static function _setAttributesByForm($addressData, $address)
    {
        $address->city_id = $addressData->city_id;
        $address->address = $addressData->address;
        $address->map_coordinates = $addressData->addressCoordinates;
        $address->time_work = $addressData->timeWork;
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyContactDatas()
    {
        return $this->hasMany(CompanyContactData::className(), ['company_address_id' => 'id']);
    }
}
