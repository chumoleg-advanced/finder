<?php

namespace common\models\company;

use Yii;
use yii\base\Exception;
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
    const STATUS_ON_MODERATE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_BLOCKED = 3;

    public static $statusList
        = [
            self::STATUS_ON_MODERATE => 'На модерации',
            self::STATUS_ACTIVE      => 'Активная',
            self::STATUS_BLOCKED     => 'Заблокирована',
        ];

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
     * @param $userId
     *
     * @return Company[]
     */
    public static function findByUser($userId)
    {
        return self::find()->whereUserId($userId)->all();
    }

    /**
     * @param $id
     *
     * @return Company
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
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

    /**
     * @param array $stepData
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function createByStepData($stepData = [])
    {
        try {
            $mainData = $stepData['mainData'][0];
            $rubricData = $stepData['rubricData'][0];
            $contactData = $stepData['contactData'][0];

        } catch (Exception $e) {
            return false;
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $model = new self();
            $model->setAttributes($mainData->attributes);
            $model->status = self::STATUS_ON_MODERATE;
            if (!$model->save()) {
                throw new Exception();
            }

            $addressId = CompanyAddress::create($model->id, $contactData->address, $rubricData->timeWork);
            foreach ($contactData->contactDataValues as $item) {
                CompanyContactData::create($model->id, $addressId, $item['typeData'], $item['valueData']);
            }

            $this->_saveRubricData($rubricData, $model);

            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param $rubricData
     * @param $model
     */
    private function _saveRubricData($rubricData, $model)
    {
        foreach ($rubricData->typePayment as $type) {
            CompanyTypePayment::create($model->id, $type);
        }

        foreach ($rubricData->typeDelivery as $type) {
            CompanyTypeDelivery::create($model->id, $type);
        }

        foreach ($rubricData->rubrics as $rubricId) {
            CompanyRubric::create($model->id, $rubricId);
        }
    }
}
