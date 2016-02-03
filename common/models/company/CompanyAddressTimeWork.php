<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "company_address_time_work".
 *
 * @property integer        $id
 * @property integer        $company_address_id
 * @property integer        $type
 * @property string         $days_list
 * @property integer        $time_from
 * @property integer        $time_to
 * @property string         $date_create
 *
 * @property CompanyAddress $companyAddress
 */
class CompanyAddressTimeWork extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_address_time_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_address_id'], 'required'],
            [['company_address_id', 'type', 'time_from', 'time_to'], 'integer'],
            [['date_create'], 'safe'],
            [['days_list'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('label', 'ID'),
            'company_address_id' => Yii::t('label', 'Company Address ID'),
            'type'               => Yii::t('label', 'Type'),
            'days_list'          => Yii::t('label', 'Days List'),
            'time_from'          => Yii::t('label', 'Time From'),
            'time_to'            => Yii::t('label', 'Time To'),
            'date_create'        => Yii::t('label', 'Date Create'),
        ];
    }

    /**
     * @param $addressId
     * @param $type
     * @param $daysList
     * @param $timeFrom
     * @param $timeTo
     */
    public static function create($addressId, $type, $daysList, $timeFrom, $timeTo)
    {
        if (empty($addressId) || empty($daysList)) {
            return;
        }

        $rel = new self();
        $rel->company_address_id = $addressId;
        $rel->type = $type;
        $rel->days_list = Json::encode($daysList);
        $rel->time_from = $timeFrom;
        $rel->time_to = $timeTo;
        $rel->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddress()
    {
        return $this->hasOne(CompanyAddress::className(), ['id' => 'company_address_id']);
    }
}
