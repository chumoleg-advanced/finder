<?php

namespace common\models\company;

use common\models\notification\Notification;
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

    public function beforeSave($insert)
    {
        if (empty($this->actual_name)) {
            $this->actual_name = $this->legal_name;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function updateStatus($status)
    {
        if (!parent::updateStatus($status)) {
            return false;
        }

        if ($this->status == self::STATUS_ACTIVE) {
            Yii::$app->consoleRunner->run('email/send ' . Notification::TYPE_ACCEPT_COMPANY
                . ' ' . $this->id . ' ' . $this->user_id);
        }

        return true;
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
                $transaction->rollBack();
                return false;
            }

            $addressId = CompanyAddress::create($model->id, $contactData);
            $this->_saveContactData($contactData, $model->id, $addressId);
            $this->_saveRubricData($rubricData, $model->id);
            $this->_saveTimeWorkData($contactData, $addressId);

            $transaction->commit();

            Yii::$app->consoleRunner->run('email/send ' . Notification::TYPE_NEW_COMPANY . ' ' . $model->id . ' ""');

            return true;

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param $contactData
     * @param $companyId
     * @param $addressId
     */
    private function _saveContactData($contactData, $companyId, $addressId)
    {
        CompanyContactData::deleteAll('company_id = ' . $companyId);
        foreach ($contactData->contactDataValues as $item) {
            CompanyContactData::create($companyId, $addressId, $item['type'], $item['data']);
        }
    }

    /**
     * @param $rubricData
     * @param $companyId
     */
    private function _saveRubricData($rubricData, $companyId)
    {
        CompanyTypePayment::deleteAll('company_id = ' . $companyId);
        foreach ($rubricData->typePayment as $type) {
            CompanyTypePayment::create($companyId, $type);
        }

        CompanyTypeDelivery::deleteAll('company_id = ' . $companyId);
        foreach ($rubricData->typeDelivery as $type) {
            CompanyTypeDelivery::create($companyId, $type);
        }

        CompanyRubric::deleteAll('company_id = ' . $companyId);
        foreach ($rubricData->rubrics as $rubricId) {
            CompanyRubric::create($companyId, $rubricId);
        }
    }

    /**
     * @param $contactData
     * @param $addressId
     */
    private function _saveTimeWorkData($contactData, $addressId)
    {
        CompanyAddressTimeWork::deleteAll('company_address_id = ' . $addressId);
        foreach ($contactData->timeWork as $k => $item) {
            CompanyAddressTimeWork::create($addressId, $k, $item['days'], $item['timeFrom'], $item['timeTo']);
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
            $oldStatus = $this->status;
            if (!Yii::$app->user->can('accessToBackend')) {
                $this->status = self::STATUS_ON_MODERATE;
            }

            if (!$this->save()) {
                throw new Exception();
            }

            $addressId = CompanyAddress::updateByCompany($this->id, $contactData);
            $this->_saveRubricData($rubricData, $this->id);
            $this->_saveContactData($contactData, $this->id, $addressId);
            $this->_saveTimeWorkData($contactData, $addressId);

            $transaction->commit();

            if ($oldStatus != self::STATUS_ON_MODERATE) {
                Yii::$app->consoleRunner->run('email/send ' . Notification::TYPE_UPDATE_COMPANY
                    . ' ' . $this->id . ' ""');
            }

            return true;

        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
