<?php

namespace common\models\request;

use common\models\user\User;
use Yii;
use common\components\ActiveRecord;
use common\models\company\Company;

/**
 * This is the model class for table "request_offer".
 *
 * @property integer $id
 * @property integer $request_id
 * @property integer $user_id
 * @property integer $company_id
 * @property string  $description
 * @property integer $status
 * @property string  $price
 * @property string  $delivery_price
 * @property string  $date_create
 *
 * @property Company $company
 * @property Request $request
 * @property User    $user
 */
class RequestOffer extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_REJECTED = 3;

    public static $statusList
        = [
            self::STATUS_NEW      => 'Новая',
            self::STATUS_ACTIVE   => 'Обработана',
            self::STATUS_REJECTED => 'Отклонена'
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
            [['request_id', 'user_id'], 'required'],
            [
                'company_id',
                'unique',
                'targetAttribute' => ['request_id', 'user_id'],
                'message'         => 'Данная заявка уже была обработана'
            ],
            [['request_id', 'user_id', 'price', 'company_id'], 'required', 'on' => 'update'],
            [['request_id', 'company_id', 'status', 'user_id'], 'integer'],
            [['description'], 'string'],
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
        $offers = self::find()
            ->joinWith('company')
            ->andWhere([
                'request_id'           => $requestId,
                'request_offer.status' => self::STATUS_ACTIVE
            ])
            ->all();

        if (empty($offers)) {
            return [null, []];
        }

        if (count($offers) == 1) {
            return [$offers[0], []];
        }

        return [array_shift($offers), $offers];
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
     * @return RequestOffer
     */
    public static function getModelByRequest($requestId)
    {
        return self::find()
            ->andWhere(['request_id' => $requestId])
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->one();
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
