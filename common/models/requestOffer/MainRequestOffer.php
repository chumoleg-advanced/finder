<?php

namespace common\models\requestOffer;

use common\components\ActiveRecord;
use Yii;
use common\models\request\Request;
use common\models\user\User;

/**
 * This is the model class for table "main_request_offer".
 *
 * @property integer        $id
 * @property integer        $user_id
 * @property integer        $request_id
 * @property integer        $status
 * @property string         $date_create
 *
 * @property Request        $request
 * @property User           $user
 * @property RequestOffer[] $requestOffers
 */
class MainRequestOffer extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_CLOSED = 3;

    public static $statusList
        = [
            self::STATUS_NEW    => 'Новая',
            self::STATUS_ACTIVE => 'Обработана',
            self::STATUS_CLOSED => 'Закрыта'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_request_offer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'request_id'], 'required'],
            [['user_id', 'request_id', 'status'], 'integer'],
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
            'user_id'     => 'Пользователь',
            'request_id'  => 'Заявка',
            'status'      => 'Статус',
            'date_create' => 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     * @return MainRequestOfferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MainRequestOfferQuery(get_called_class());
    }

    /**
     * @param $id
     *
     * @return null|RequestOffer
     */
    public static function findById($id)
    {
        return self::find()
            ->whereId($id)
            ->joinWith('request')
            ->joinWith('requestOffers')
            ->one();
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
    public function getRequestOffers()
    {
        return $this->hasMany(RequestOffer::className(), ['main_request_offer_id' => 'id']);
    }
}
