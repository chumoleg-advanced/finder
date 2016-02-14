<?php

namespace common\models\notification;

use Yii;
use common\models\user\User;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string  $message
 * @property integer $status
 * @property string  $data
 * @property string  $date_create
 *
 * @property User    $user
 */
class Notification extends \common\components\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_READ = 2;

    const TYPE_SITE_NEWS = 1;

    const TYPE_NEW_REQUEST = 2;
    const TYPE_ACCEPT_REQUEST = 3;
    const TYPE_NEW_OFFER = 4;
    const TYPE_NEW_COMPANY = 5;
    const TYPE_UPDATE_COMPANY = 6;
    const TYPE_ACCEPT_COMPANY = 7;
    const TYPE_NEW_MESSAGE = 8;

    public static $typeListForUser
        = [
            self::TYPE_NEW_MESSAGE    => 'О новых сообщениях',
            self::TYPE_ACCEPT_REQUEST => 'О поступлении новых заявок',
            self::TYPE_NEW_OFFER      => 'О поступлении новых предложений'
        ];

    public static $subjectList
        = [
            self::TYPE_NEW_REQUEST    => 'Новая заявка №{modelId}',
            self::TYPE_ACCEPT_REQUEST => 'Новая заявка №{modelId}',
            self::TYPE_NEW_OFFER      => 'Новое предложение по заявке №{modelId}',
            self::TYPE_NEW_COMPANY    => 'Новая компания: ID{modelId}',
            self::TYPE_UPDATE_COMPANY => 'Требуется модерация компании ID{modelId}',
            self::TYPE_ACCEPT_COMPANY => 'Проверка компании {modelName} завершена',
            self::TYPE_NEW_MESSAGE    => 'Новое сообщение по заявке №{modelId}'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type', 'status'], 'integer'],
            [['data'], 'string'],
            [['date_create'], 'safe'],
            [['message'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'user_id'     => 'User ID',
            'type'        => 'Type',
            'message'     => 'Message',
            'status'      => 'Status',
            'data'        => 'Data',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @param int    $userId
     * @param int    $type
     * @param string $message
     */
    public static function create($userId, $type, $message)
    {
        $model = new self();
        $model->user_id = $userId;
        $model->type = $type;
        $model->message = $message;
        $model->save();
    }

    /**
     * @return array|Notification
     */
    public static function getNotificationList()
    {
        return self::find()
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->orderBy('id DESC')
            ->all();
    }

    /**
     * @return int
     */
    public static function getCountNewNotifications()
    {
        return (int)self::find()->where('user_id = ' . Yii::$app->user->id
            . ' AND status = ' . self::STATUS_NEW)->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
