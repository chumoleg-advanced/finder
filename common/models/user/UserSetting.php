<?php

namespace common\models\user;

use Yii;
use common\components\ActiveRecord;

/**
 * This is the model class for table "user_setting".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $data
 * @property string  $date_create
 *
 * @property User    $user
 */
class UserSetting extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
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
            'id'          => 'ID',
            'user_id'     => 'User ID',
            'data'        => 'Data',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return UserSettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserSettingQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
