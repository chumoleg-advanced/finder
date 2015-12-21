<?php

namespace common\models\company;

use Yii;

/**
 * This is the model class for table "company_type_delivery".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $type
 * @property string  $date_create
 *
 * @property Company $company
 */
class CompanyTypeDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_type_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'type'], 'required'],
            [['company_id', 'type'], 'integer'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'company_id'  => 'Company ID',
            'type'        => 'Type',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyTypeDeliveryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyTypeDeliveryQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            1 => 'Доставка по городу',
            2 => 'Доставка межгород',
            3 => 'Самовывоз'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
