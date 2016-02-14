<?php

namespace common\models\notification;

use Yii;
use common\models\user\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notification_setting".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property string  $date_create
 *
 * @property User    $user
 */
class NotificationSetting extends \common\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['date_create'], 'safe']
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
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @param int $userId
     * @param int $type
     *
     * @throws \Exception
     */
    public static function manage($userId, $type)
    {
        if (empty($userId) || empty($type)) {
            return;
        }

        $check = self::find()->andWhere(['user_id' => $userId, 'type' => $type])->one();
        if (!empty($check)) {
            $check->delete();

        } else {
            $model = new self();
            $model->user_id = $userId;
            $model->type = $type;
            $model->save();
        }
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getTypeListByUser($userId)
    {
        $data = self::find()->andWhere(['user_id' => $userId])->all();
        return array_unique(ArrayHelper::getColumn($data, 'type'));
    }

    /**
     * @param int $type
     *
     * @return User[]
     */
    public static function getUserListByType($type)
    {
        $data = self::find()->joinWith('user')->andWhere(['notification_setting.type' => $type])->all();
        return ArrayHelper::getColumn($data, 'user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
