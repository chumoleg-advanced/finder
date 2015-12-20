<?php

namespace common\models\company;

use Yii;
use yii\db\ActiveRecord;
use common\models\city\City;
use common\models\user\User;

/**
 * This is the model class for table "company".
 *
 * @property integer               $id
 * @property integer               $status
 * @property integer               $city_id
 * @property integer               $user_id
 * @property string                $legal_name
 * @property string                $actual_name
 * @property integer               $form
 * @property string                $inn
 * @property string                $ogrn
 * @property string                $date_create
 *
 * @property City                  $city
 * @property User                  $user
 * @property CompanyAddress[]      $companyAddresses
 * @property CompanyContactData[]  $companyContactDatas
 * @property CompanyRubric[]       $companyRubrics
 * @property CompanyTypeDelivery[] $companyTypeDeliveries
 * @property CompanyTypePayment[]  $companyTypePayments
 */
class Company extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'city_id', 'user_id', 'form'], 'required'],
            [['status', 'city_id', 'user_id', 'form'], 'integer'],
            [['date_create'], 'safe'],
            [['legal_name', 'actual_name'], 'string', 'max' => 250],
            [['inn'], 'string', 'max' => 12],
            [['ogrn'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'status'      => 'Status',
            'city_id'     => 'City ID',
            'user_id'     => 'User ID',
            'legal_name'  => 'Legal Name',
            'actual_name' => 'Actual Name',
            'form'        => 'Form',
            'inn'         => 'Inn',
            'ogrn'        => 'Ogrn',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getCreateStepList()
    {
        return [
            'Общая информация'   => 'mainData',
            'Сфера деятельности' => 'rubricData',
            'Контактные данные'  => 'contactData'
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddresses()
    {
        return $this->hasMany(CompanyAddress::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyContactDatas()
    {
        return $this->hasMany(CompanyContactData::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyRubrics()
    {
        return $this->hasMany(CompanyRubric::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTypeDeliveries()
    {
        return $this->hasMany(CompanyTypeDelivery::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTypePayments()
    {
        return $this->hasMany(CompanyTypePayment::className(), ['company_id' => 'id']);
    }
}
