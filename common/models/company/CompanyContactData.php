<?php

namespace common\models\company;

use Yii;

/**
 * This is the model class for table "company_contact_data".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $company_address_id
 * @property integer $type
 * @property string $data
 * @property string $date_create
 *
 * @property CompanyAddress $companyAddress
 * @property Company $company
 */
class CompanyContactData extends \yii\db\ActiveRecord
{
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
            'id' => 'ID',
            'company_id' => 'Company ID',
            'company_address_id' => 'Company Address ID',
            'type' => 'Type',
            'data' => 'Data',
            'date_create' => 'Date Create',
        ];
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

    /**
     * @inheritdoc
     * @return CompanyContactDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyContactDataQuery(get_called_class());
    }
}
