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
    const TYPE_REQUEST = 1;
    const TYPE_COMPANY = 2;

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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
