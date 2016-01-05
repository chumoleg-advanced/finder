<?php

namespace common\models\request;

use common\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "request_view".
 *
 * @property integer $id
 * @property integer $request_id
 * @property integer $user_ip
 * @property string  $date_create
 */
class RequestView extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'user_ip'], 'required'],
            [['request_id', 'user_ip'], 'integer'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @param $requestId
     *
     * @return bool
     */
    public static function findByUserIp($requestId)
    {
        $userIp = ip2long(Yii::$app->request->getUserIP());
        $result = (bool)self::find()->andWhere(['user_ip' => $userIp, 'request_id' => $requestId])->one();

        if (!$result) {
            $model = new self();
            $model->request_id = $requestId;
            $model->user_ip = $userIp;
            $model->save();
        }

        return $result;
    }
}
