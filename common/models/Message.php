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
            'request_id'   => 'Request ID',
            'from_user_id' => 'From User ID',
            'to_user_id'   => 'To User ID',
            'data'         => 'Data',
            'status'       => 'Status',
            'date_create'  => 'Date Create',
        ];
    }

    public function beforeSave($insert)
    {
        if (empty($this->from_user_id)) {
            $this->from_user_id = Yii::$app->user->id;
        }

        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
        }

        return parent::beforeSave($insert);
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
        $userId = Yii::$app->user->id;
        return self::find()->where('(from_user_id = ' . $userId . ' OR to_user_id = ' . $userId
            . ') AND request_id = ' . $requestId)->all();
    }

    /**
     * @return int
     */
    public static function countNewMessages()
    {
        return (int)self::find()->count('to_user_id = ' . Yii::$app->user->id
            . ' AND status = ' . self::STATUS_NEW);
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

    public static function getDialogList()
    {
        return self::find();
    }
}
