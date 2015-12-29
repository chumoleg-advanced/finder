<?php

namespace common\models\request;

use Yii;
use common\components\ActiveRecord;
use yii\helpers\Json;

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
class RequestPosition extends ActiveRecord
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
            'request_id'  => 'Заявка',
            'description' => 'Описание',
            'comment'     => 'Комментарий',
            'data'        => 'Data',
            'date_create' => 'Дата создания',
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
        $this->data = Json::encode($this->data);
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->data = Json::decode($this->data);
        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
