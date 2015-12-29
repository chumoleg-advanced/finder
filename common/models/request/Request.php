<?php

namespace common\models\request;

use common\models\company\Company;
use Yii;
use common\models\rubric\Rubric;
use common\models\user\User;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use common\components\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "request".
 *
 * @property integer           $id
 * @property integer           $rubric_id
 * @property integer           $status
 * @property string            $data
 * @property integer           $user_id
 * @property integer           $performer_company_id
 * @property integer           $request_offer_id
 * @property string            $date_create
 *
 * @property Rubric            $rubric
 * @property User              $user
 * @property RequestPosition[] $requestPositions
 */
class Request extends ActiveRecord
{
    const STATUS_ON_MODERATE = 1;
    const STATUS_REJECTED = 2;
    const STATUS_WAITING = 3;
    const STATUS_OFFER_SENT = 4;
    const STATUS_IN_WORK = 5;
    const STATUS_CLOSED = 6;

    public static $statusList
        = [
            self::STATUS_ON_MODERATE => 'На модерации',
            self::STATUS_REJECTED    => 'Отклонена',
            self::STATUS_OFFER_SENT  => 'Открыто для предложений',
            self::STATUS_IN_WORK     => 'В обработке',
            self::STATUS_CLOSED      => 'Завершена',
        ];

    public static $statusListCompany
        = [
            self::STATUS_WAITING => 'Новая',
            self::STATUS_IN_WORK => 'В обработке',
            self::STATUS_CLOSED  => 'Завершена',
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rubric_id', 'user_id'], 'required'],
            [['rubric_id', 'user_id', 'performer_company_id', 'request_offer_id', 'status'], 'integer'],
            [['data'], 'string'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'rubric_id'            => 'Рубрика',
            'status'               => 'Статус',
            'data'                 => 'Data',
            'user_id'              => 'Пользователь',
            'performer_company_id' => 'Компания',
            'request_offer_id'     => 'Выбранное предложение',
            'date_create'          => 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestQuery(get_called_class());
    }

    public function beforeValidate()
    {
        $this->data = Json::encode($this->data);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->data = Json::decode($this->data);
        return parent::afterFind();
    }

    /**
     * @param $id
     *
     * @return null|Request
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubric::className(), ['id' => 'rubric_id']);
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
    public function getPerformerCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'performer_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOffer()
    {
        return $this->hasOne(RequestOffer::className(), ['id' => 'request_offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestPositions()
    {
        return $this->hasMany(RequestPosition::className(), ['request_id' => 'id']);
    }

    /**
     * @param $rubricId
     * @param $attributes
     * @param $positions
     *
     * @return bool
     */
    public function createModelFromPost($rubricId, $attributes, $positions)
    {
        try {
            if (!$requestId = $this->_createNewRequest($rubricId, $attributes)) {
                return false;
            }

            $this->_savePositions($positions, $requestId);
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $rubricId
     * @param $attributes
     *
     * @return int
     */
    private function _createNewRequest($rubricId, $attributes)
    {
        $request = new self();
        $request->user_id = Yii::$app->user->id;
        $request->rubric_id = $rubricId;
        $request->status = self::STATUS_ON_MODERATE;
        $request->data = $attributes;
        $request->save();

        $requestId = $request->id;
        return $requestId;
    }

    /**
     * @param $positions
     * @param $requestId
     *
     * @return \yii\web\UploadedFile
     */
    private function _savePositions($positions, $requestId)
    {
        foreach ($positions as $posAttr) {
            if (!empty($posAttr['image'])) {
                /** @var \yii\web\UploadedFile $fileObj */
                foreach ($posAttr['image'] as &$fileObj) {
                    $dir = 'uploads/' . $requestId;
                    if (!is_dir($dir)) {
                        mkdir($dir);
                    }

                    $fileName = $dir . '/' . md5($fileObj->name . '_' . mktime());

                    $fileObj->saveAs($fileName);
                    $fileObj = $fileName;
                }
                unset($fileObj);
            }

            $this->_savePositionRow($requestId, $posAttr);
        }
    }

    /**
     * @param $requestId
     * @param $posAttr
     */
    private function _savePositionRow($requestId, $posAttr)
    {
        $rel = new RequestPosition();
        $rel->request_id = $requestId;
        $rel->description = ArrayHelper::getValue($posAttr, 'description');
        $rel->comment = ArrayHelper::getValue($posAttr, 'comment');

        unset($posAttr['description']);
        unset($posAttr['comment']);

        $rel->data = $posAttr;
        $rel->save();
    }
}
