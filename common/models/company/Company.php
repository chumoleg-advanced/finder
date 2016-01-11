<?php

namespace common\models\company;

use Yii;
use yii\base\Exception;
use common\components\ActiveRecord;
use common\models\user\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company".
 *
 * @property integer               $id
 * @property integer               $status
 * @property integer               $user_id
 * @property string                $legal_name
 * @property string                $actual_name
 * @property integer               $form
 * @property string                $inn
 * @property string                $ogrn
 * @property string                $date_create
 *
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
            [['status', 'user_id', 'form'], 'required'],
            [['status', 'user_id', 'form'], 'integer'],
            [['date_create'], 'safe'],
            [['legal_name', 'actual_name'], 'string', 'max' => 250],
            [['inn', 'ogrn'], 'double'],
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
            'status'      => 'Статус',
            'user_id'     => 'Пользователь',
            'legal_name'  => 'Юридическое название',
            'actual_name' => 'Фактическое название',
            'form'        => 'Форма организации',
            'inn'         => 'ИНН',
            'ogrn'        => 'ОГРН',
            'date_create' => 'Дата создания',
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

    public function beforeValidate()
    {
        if (empty($this->user_id)) {
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
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
     * @param $id
     *
     * @return Company
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
    }

    /**
     * @param $userId
     *
     * @return array
     */
    public static function getListByUser($userId = null)
    {
        if (empty($userId)) {
            $userId = Yii::$app->user->id;
        }

        $data = self::find()->whereUserId($userId)->all();
        return ArrayHelper::map($data, 'id', 'legal_name');
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
//        try {
        $mainData = $stepData['mainData'][0];
        $rubricData = $stepData['rubricData'][0];
        $contactData = $stepData['contactData'][0];

//        } catch (Exception $e) {
//            return false;
//        }

        $transaction = $this->getDb()->beginTransaction();

//        try {
        $model = new self();
        $model->setAttributes($mainData->attributes);
        $model->status = self::STATUS_ON_MODERATE;
        if (!$model->save()) {
            print_r($model->errors);
            die;
            throw new Exception();
        }

        $addressId = CompanyAddress::create($model->id, $contactData);
        foreach ($contactData->contactDataValues as $item) {
            CompanyContactData::create($model->id, $addressId, $item['type'], $item['data']);
        }

        $this->_saveRubricData($rubricData, $model);

        $transaction->commit();
        return true;

//        } catch (Exception $e) {
//            $transaction->rollBack();
//            return false;
//        }
    }

    /**
     * @param $rubricData
     * @param $model
     */
    private function _saveRubricData($rubricData, $model)
    {
        CompanyTypePayment::deleteAll('company_id = ' . $model->id);
        foreach ($rubricData->typePayment as $type) {
            CompanyTypePayment::create($model->id, $type);
        }

        CompanyTypeDelivery::deleteAll('company_id = ' . $model->id);
        foreach ($rubricData->typeDelivery as $type) {
            CompanyTypeDelivery::create($model->id, $type);
        }

        CompanyRubric::deleteAll('company_id = ' . $model->id);
        foreach ($rubricData->rubrics as $rubricId) {
            CompanyRubric::create($model->id, $rubricId);
        }
    }

    /**
     * @param $mainData
     * @param $rubricData
     * @param $contactData
     *
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateModel($mainData, $rubricData, $contactData)
    {
        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->setAttributes($mainData->attributes);
            $this->status = self::STATUS_ON_MODERATE;
            if (!$this->save()) {
                throw new Exception();
            }

            $addressId = CompanyAddress::updateByCompany($this->id, $contactData);

            CompanyContactData::deleteAll('company_id = ' . $this->id);
            foreach ($contactData->contactDataValues as $item) {
                CompanyContactData::create($this->id, $addressId, $item['type'], $item['data']);
            }

            $this->_saveRubricData($rubricData, $this);

            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
