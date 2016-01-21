<?php

namespace common\models\requestOffer;

use common\components\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "request_offer_attribute".
 *
 * @property integer      $id
 * @property integer      $request_offer_id
 * @property string       $attribute_name
 * @property string       $value
 *
 * @property RequestOffer $requestOffer
 */
class RequestOfferAttribute extends ActiveRecord
{
    /**
     * @param $requestOfferId
     * @param $name
     *
     * @return mixed
     */
    public static function getValueByOffer($requestOfferId, $name)
    {
        if (empty($requestOfferId) || empty($name)) {
            return null;
        }

        $data = self::find()
            ->andWhere(['request_offer_id' => $requestOfferId])
            ->andWhere(['attribute_name' => $name])
            ->one();

        return !empty($data) ? $data->value : null;
    }

    /**
     * @param $requestOfferId
     *
     * @return mixed
     */
    public static function findAllByOffer($requestOfferId)
    {
        if (empty($requestOfferId)) {
            return null;
        }

        $data = self::find()->andWhere(['request_offer_id' => $requestOfferId])->all();

        return ArrayHelper::map($data, 'attribute_name', 'value');
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['dateCreate']);

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_offer_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_offer_id', 'attribute_name'], 'required'],
            [['request_offer_id'], 'integer'],
            [['value'], 'string'],
            [['attribute_name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'request_offer_id' => 'Request Offer ID',
            'attribute_name'   => 'Attribute Name',
            'value'            => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOffer()
    {
        return $this->hasOne(RequestOffer::className(), ['id' => 'request_offer_id']);
    }
}
