<?php

namespace common\models\message;

use Yii;
use common\components\ActiveRecord;
use common\models\request\Request;
use common\models\user\User;
use common\models\company\Company;

/**
 * This is the model class for table "message_dialog".
 *
 * @property integer   $id
 * @property integer   $request_id
 * @property integer   $sender
 * @property integer   $from_user_id
 * @property integer   $to_user_id
 * @property integer   $company_id
 * @property string    $date_create
 *
 * @property Message[] $messages
 * @property User      $fromUser
 * @property Request   $request
 * @property Company   $company
 * @property User      $toUser
 */
class MessageDialog extends ActiveRecord
{
    const SENDER_USER = 1;
    const SENDER_COMPANY = 2;

    public $countNew;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_dialog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'from_user_id', 'to_user_id'], 'required'],
            [['request_id', 'sender', 'from_user_id', 'to_user_id', 'company_id'], 'integer'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }

    public function beforeValidate()
    {
        if (empty($this->from_user_id)) {
            $this->from_user_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array|Message[]
     */
    public static function getDialogList()
    {
        return self::find()
            ->joinWith(['request', 'company'])
            ->select([
                'message_dialog.*',
                '(SELECT COUNT(id) FROM message WHERE message_dialog_id = message_dialog.id
                    AND status = 1 AND to_user_id = ' . Yii::$app->user->id . ') AS countNew'
            ])
            ->andWhere(self::_getUserCondition())
            ->orderBy('message_dialog.id DESC')
            ->all();
    }

    /**
     * @return string
     */
    private static function _getUserCondition()
    {
        $userId = Yii::$app->user->id;
        return 'message_dialog.from_user_id = ' . $userId . ' OR message_dialog.to_user_id = ' . $userId;
    }

    /**
     * @param $id
     *
     * @return null|MessageDialog
     */
    public static function findById($id)
    {
        return self::find()->joinWith(['messages'])->where(['message_dialog.id' => $id])->one();
    }

    /**
     * @param $requestId
     * @param $companyId
     * @param $toUserId
     * @param $sender
     *
     * @return MessageDialog|null
     */
    public static function getByRequestAndCompany($requestId, $companyId, $toUserId, $sender = self::SENDER_USER)
    {
        $attributes = [
            'request_id' => $requestId,
            'to_user_id' => $toUserId
        ];

        if ($sender == self::SENDER_USER) {
            $attributes['company_id'] = $companyId;
        }

        $model = self::find()->andWhere($attributes)->one();
        if (empty($model)) {
            $model = self::find()->andWhere([
                'request_id'   => $requestId,
                'from_user_id' => $toUserId
            ])->one();
        }

        if (empty($model)) {
            $model = new self();
            $model->attributes = $attributes;
            $model->company_id = $companyId;
            $model->sender = $sender;
            $model->save();
        }

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['message_dialog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
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
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return string
     */
    public function getDialogDescription()
    {
        $messageBadge = '';
        if ($this->countNew > 0) {
            $messageBadge = '<span class="badge">' . $this->countNew . '</span>';
        }

        $description = 'Заявка №' . $this->request_id . '. ' . $this->request->description
            . '. Переписка с клиентом. ' . $messageBadge;
        if (($this->sender == MessageDialog::SENDER_COMPANY && $this->from_user_id != Yii::$app->user->id)
            || ($this->sender == MessageDialog::SENDER_USER && $this->to_user_id != Yii::$app->user->id)
        ) {
            $description = 'Заявка №' . $this->request_id . '. Переписка с '
                . $this->company->actual_name . '. ' . $messageBadge;
        }

        return $description;
    }
}
