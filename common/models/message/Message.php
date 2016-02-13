<?php

namespace common\models\message;

use common\models\requestOffer\RequestOffer;
use Yii;
use common\components\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "message".
 *
 * @property integer       $id
 * @property integer       $message_dialog_id
 * @property integer       $from_user_id
 * @property integer       $to_user_id
 * @property string        $data
 * @property integer       $status
 * @property string        $date_create
 *
 * @property MessageDialog $messageDialog
 * @property User          $toUser
 * @property User          $user
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
            [['data'], 'filter', 'filter' => 'trim'],
            [['message_dialog_id', 'from_user_id', 'to_user_id'], 'required'],
            [['message_dialog_id', 'from_user_id', 'to_user_id', 'status'], 'integer'],
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
            'id'                => 'ID',
            'message_dialog_id' => 'Переписка',
            'from_user_id'      => 'Отправитель',
            'to_user_id'        => 'Получатель',
            'data'              => 'Сообщение',
            'status'            => 'Статус',
            'date_create'       => 'Дата сообшения',
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
     * @return int
     */
    public static function getCountNewMessages()
    {
        return (int)self::find()->where('to_user_id = ' . Yii::$app->user->id
            . ' AND status = ' . self::STATUS_NEW)->count();
    }

    /**
     * @param int $messageDialogId
     */
    public static function readMessage($messageDialogId)
    {
        self::updateAll(['status' => self::STATUS_READ],
            'status = ' . self::STATUS_NEW . ' AND message_dialog_id = ' . $messageDialogId
            . ' AND to_user_id = ' . Yii::$app->user->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageDialog()
    {
        return $this->hasOne(MessageDialog::className(), ['id' => 'message_dialog_id']);
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
     * @param int $requestId
     *
     * @return int
     */
    public static function getCountByRequest($requestId)
    {
        return (int)self::find()
            ->joinWith('messageDialog')
            ->where('message_dialog.request_id = ' . $requestId)
            ->count();
    }

    /**
     * @param int $mainRequestOfferId
     *
     * @return int
     */
    public static function getCountByMainRequestOffer($mainRequestOfferId)
    {
        return (int)self::find()
            ->joinWith('messageDialog')
            ->where('message_dialog.request_id IN (SELECT request_id FROM ' . RequestOffer::tableName() . '
                WHERE main_request_offer_id = ' . $mainRequestOfferId  . ')')
            ->count();
    }
}
