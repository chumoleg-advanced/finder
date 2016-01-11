<?php

namespace common\models\request;

use Yii;
use common\components\ActiveRecord;

/**
 * This is the model class for table "request_image".
 *
 * @property integer $id
 * @property integer $request_id
 * @property string  $name
 * @property string  $date_create
 *
 * @property Request $request
 */
class RequestImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'name'], 'required'],
            [['request_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'request_id'  => 'Request ID',
            'name'        => 'Name',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
