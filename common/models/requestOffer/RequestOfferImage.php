<?php

namespace common\models\requestOffer;

use common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "request_offer_image".
 *
 * @property integer      $id
 * @property integer      $request_offer_id
 * @property string       $name
 * @property string       $thumb_name
 * @property string       $date_create
 *
 * @property RequestOffer $requestOffer
 */
class RequestOfferImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_offer_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_offer_id', 'name', 'thumb_name'], 'required'],
            [['request_offer_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name', 'thumb_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOffer()
    {
        return $this->hasOne(RequestOffer::className(), ['id' => 'request_offer_id']);
    }
}
