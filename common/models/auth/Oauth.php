<?php

namespace common\models\auth;

use Yii;
use \yii\db\ActiveRecord;
use common\models\user\User;

/**
 * This is the model class for table "oauth".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $source
 * @property string  $source_id
 *
 * @property User    $user
 */
class Oauth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('label', 'ID'),
            'user_id'   => Yii::t('label', 'User ID'),
            'source'    => Yii::t('label', 'Source'),
            'source_id' => Yii::t('label', 'Source ID'),
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
