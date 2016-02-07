<?php

namespace common\models;

use Yii;
use common\components\ActiveRecord;
use common\models\request\Request;
use common\models\user\User;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $request_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string  $data
 * @property integer $status
 * @property string  $date_create
 *
 * @property Request $request
 * @property User    $toUser
 * @property User    $user
 */
class Message extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_READ = 2;

    public $countNew;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data'], 'filter', 'filter' => 'trim'],
            [['request_id', 'from_user_id', 'to_user_id'], 'required'],
            [['request_id', 'from_user_id', 'to_user_id', 'status'], 'integer'],
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
            'id'           => 'ID',
            'request_id'   => 'Заявка',
            'from_user_id' => 'Отправитель',
            'to_user_id'   => 'Получатель',
            'data'         => 'Сообщение',
            'status'       => 'Статус',
            'date_create'  => 'Дата сообшения',
        ];
    }

    public function beforeValidate()
    {
        if (empty($this->from_user_id)) {
            $this->from_user_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param int    $requestId
     * @param int    $toUserId
     * @param string $text
     */
    public static function createMessage($requestId, $toUserId, $text)
    {
        $model = new self();
        $model->request_id = $requestId;
        $model->to_user_id = $toUserId;
        $model->data = $text;
        $model->save();
    }

    /**
     * @param int $requestId
     *
     * @return Message[]|null
     */
    public static function getMessageListByRequest($requestId)
    {
        return self::find()
            ->andWhere(self::_getUserCondition())
            ->andWhere('request_id = ' . $requestId)
            ->all();
    }

    /**
     * @return string
     */
    private static function _getUserCondition()
    {
        $userId = Yii::$app->user->id;
        return 'message.from_user_id = ' . $userId . ' OR to_user_id = ' . $userId;
    }

    /**
     * @return int
     */
    public static function getCountNewMessages()
    {
        return (int)self::find()->where('to_user_id = ' . Yii::$app->user->id
            . ' AND status = ' . self::STATUS_NEW)->count();
    }

    /**
     * @param int $requestId
     */
    public static function readMessage($requestId)
    {
        self::updateAll(['status' => self::STATUS_READ],
            'status = ' . self::STATUS_NEW . ' AND request_id = ' . $requestId
            . ' AND to_user_id = ' . Yii::$app->user->id);
    }

    /**
     * @return array|Message[]
     */
    public static function getDialogList()
    {
        return self::find()
            ->joinWith('request')
            ->select([
                '*',
                'COUNT(IF(message.status = 1 AND message.to_user_id = ' . Yii::$app->user->id . ',
                    message.id, NULL)) AS countNew'
            ])
            ->andWhere(self::_getUserCondition())
            ->groupBy('message.request_id')
            ->orderBy('message.id DESC')
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }
}
