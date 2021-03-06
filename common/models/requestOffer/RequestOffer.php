<?php

namespace common\models\requestOffer;

use common\models\request\RequestAttribute;
use Yii;
use common\components\ActiveRecord;
use common\models\company\Company;
use common\models\request\Request;
use common\models\user\User;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "request_offer".
 *
 * @property integer                 $id
 * @property integer                 $main_request_offer_id
 * @property integer                 $request_id
 * @property integer                 $user_id
 * @property integer                 $company_id
 * @property string                  $description
 * @property string                  $comment
 * @property integer                 $status
 * @property string                  $price
 * @property string                  $delivery_price
 * @property string                  $date_create
 *
 * @property Company                 $company
 * @property MainRequestOffer        $mainRequestOffer
 * @property Request                 $request
 * @property User                    $user
 * @property RequestOfferAttribute[] $requestOfferAttributes
 * @property RequestOfferImage[]     $requestOfferImages
 */
class RequestOffer extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_CLOSED = 2;

    public static $statusList
        = [
            self::STATUS_ACTIVE => 'Открыто',
            self::STATUS_CLOSED => 'Закрыто'
        ];

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
            [['main_request_offer_id', 'request_id', 'user_id', 'company_id'], 'required'],
            [['main_request_offer_id', 'request_id', 'user_id', 'price', 'company_id'], 'required', 'on' => 'update'],
            [['request_id', 'company_id', 'status', 'user_id'], 'integer'],
            [['description', 'comment'], 'string'],
            [['price', 'delivery_price'], 'number'],
            [['price', 'delivery_price'], 'double', 'min' => 0],
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
            'user_id'        => 'Пользователь',
            'company_id'     => 'Компания',
            'description'    => 'Описание',
            'comment'        => 'Комментарий',
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

    /**
     * @param $id
     *
     * @return null|RequestOffer
     */
    public static function findById($id)
    {
        return self::find()->whereId($id)->joinWith('request')->one();
    }

    /**
     * @param int $requestId
     *
     * @return null|RequestOffer
     */
    public static function getBestOfferByRequest($requestId)
    {
        return self::find()
            ->joinWith('company')
            ->andWhere([
                'request_offer.request_id' => $requestId,
                'request_offer.status'     => self::STATUS_ACTIVE
            ])
            ->orderBy('request_offer.price')
            ->one();
    }

    /**
     * @param int $requestId
     * @param int $ignoreId
     *
     * @return ActiveDataProvider
     */
    public static function getOtherOffersByRequest($requestId, $ignoreId)
    {
        $query = self::find()
            ->joinWith('company')
            ->andWhere([
                'request_offer.request_id' => $requestId,
                'request_offer.status'     => self::STATUS_ACTIVE,
            ])
            ->andWhere(['!=', 'request_offer.id', $ignoreId])
            ->orderBy('request_offer.price');

        return new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
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
    public function getMainRequestOffer()
    {
        return $this->hasOne(MainRequestOffer::className(), ['id' => 'main_request_offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOfferAttributes()
    {
        return $this->hasMany(RequestOfferAttribute::className(), ['request_offer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOfferImages()
    {
        return $this->hasMany(RequestOfferImage::className(), ['request_offer_id' => 'id']);
    }

    public function getAttributesData()
    {
        $array = [];
        foreach ($this->requestOfferAttributes as $attr) {
            $array[$attr->attribute_name] = RequestAttribute::getValueForDetail($attr->attribute_name, $attr->value);
        }

        return $array;
    }
}
