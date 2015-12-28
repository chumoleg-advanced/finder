<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;

/**
 * This is the model class for table "company_type_payment".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $type
 * @property string  $date_create
 *
 * @property Company $company
 */
class CompanyTypePayment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_type_payment';
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
     * @return CompanyTypePaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyTypePaymentQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            1 => 'Наличный расчет',
            2 => 'Банковская карта',
            3 => 'Оплата через интернет',
            4 => 'Оплата через банк'
        ];
    }

    /**
     * @param $companyId
     * @param $type
     */
    public static function create($companyId, $type)
    {
        $rel = new self();
        $rel->company_id = $companyId;
        $rel->type = $type;
        $rel->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
