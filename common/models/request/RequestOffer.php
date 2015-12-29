<?php

namespace common\models\request;

use Yii;
use common\components\ActiveRecord;
use common\models\company\Company;

/**
 * This is the model class for table "request_offer".
 *
 * @property integer $id
 * @property integer $request_id
 * @property integer $company_id
 * @property string  $description
 * @property integer $status
 * @property string  $price
 * @property string  $delivery_price
 * @property string  $date_create
 *
 * @property Company $company
 * @property Request $request
 */
class RequestOffer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_offer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'company_id', 'price'], 'required'],
            [['request_id', 'company_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['price', 'delivery_price'], 'number'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'request_id'     => 'Заявка',
            'company_id'     => 'Компания',
            'description'    => 'Описание',
            'status'         => 'Статус',
            'price'          => 'Цена',
            'delivery_price' => 'Стоимость доставки',
            'date_create'    => 'Дата создания'
        ];
    }

    /**
     * @inheritdoc
     * @return RequestOfferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestOfferQuery(get_called_class());
    }

    public static function findListByRequest($requestId)
    {
        $offers = self::find()->joinWith('company')->andWhere(['request_id' => $requestId])->all();
        if (empty($offers)) {
            return [null, []];
        }

        if (count($offers) == 1) {
            return [$offers[0], []];
        }

        return [array_shift($offers), $offers];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    /**
     * @param $id
     *
     * @return null|RequestOffer
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->one();
    }
}
