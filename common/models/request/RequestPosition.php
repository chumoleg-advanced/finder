<?php

namespace common\models\request;

use Yii;

/**
 * This is the model class for table "request_position".
 *
 * @property integer $id
 * @property integer $request_id
 * @property string  $description
 * @property string  $comment
 * @property string  $data
 * @property string  $date_create
 *
 * @property Request $request
 */
class RequestPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'description'], 'required'],
            [['request_id'], 'integer'],
            [['data'], 'string'],
            [['date_create'], 'safe'],
            [['description', 'comment'], 'string', 'max' => 500]
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
            'description' => 'Description',
            'comment'     => 'Comment',
            'data'        => 'Data',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestPositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestPositionQuery(get_called_class());
    }

    public function beforeValidate()
    {
        $this->data = \yii\helpers\Json::encode($this->data);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->data = \yii\helpers\Json::decode($this->data);
        return parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
